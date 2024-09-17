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
			header("Location: http://".$ipservidorapache."/".$folderservidor."/permissiondenied.php?b=".$_SESSION["b"]."&c=".array_pop(explode('/', $_SERVER['PHP_SELF'])));
			exit();
		}
	
	
	
	$status = $connect->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	
	if ($status !="Connection OK; waiting to send.")
	{
	
		header("Location: http://".$ipservidorapache."/".$folderservidor."/errorconect.php");
		exit;
		
	}
	
	/// DETECTO PERMISOS EN PAG!
	
	
		 $sql = $connect->prepare("select bum.idmenu, menu_action.idmenu_action,  menu_action.nameaction from business_user_menu as bum inner join menu on menu.idmenu = bum.idmenu left join business_user_menu_action as buma on buma.idbusiness = bum.idbusiness and buma.iduserfas =  bum.iduserfas and buma.idmenu =  bum.idmenu left join menu_action on menu_action.idmenu_action = buma.idaction where menu.linkaccess  =  '".array_pop(explode('/', $_SERVER['PHP_SELF']))."' and bum.iduserfas = ".$_SESSION["a"]." and bum.idbusiness = ".$_SESSION["i"]);
		$sql->execute();
		$resultado = $sql->fetchAll();							
			
		$permiso_create_edit_po = "N";
		$permiso_print_label_flex ="N";
		$permiso_param_po = "N";
		$permiso_assing_so = "N";
		$permiso_assing_sn = "N";
		
		foreach ($resultado as $row) 
		{
			
			if ( $row["idmenu_action"]==6)
			{
			//6 Create Rev SO
				$permiso_create_edit_po = "Y";			
			}
			//7 Print Label Flex - FinalCheck
			if ( $row["idmenu_action"]==7)
			{
				$permiso_print_label_flex ="Y";
			}
		}
	
		
	////// PROCESAMOS EL POST POR LA NEW REVISION
	if (isset($_POST['poselecm']))
	{
		$vmaxid = $_POST['poselecm'];
		
		
	
		//updateamos datos de la revision
  
		$vconcero=0;
		$vvacio="";
		$v0 = $_REQUEST['txtlistcustomers']; ///$vidcustomer idtxtlistcustomers
		$v1 = $_REQUEST['txtlistcius']; /// idtxtlistcius
		$v2 = $_REQUEST['txtlistcius']; //txtlistcius 
		$v3 = $_REQUEST['txtponumber']; //
		$v4 = $_REQUEST['txtpwrsupply']; //
		
		$vtxtsoexternal = $_REQUEST['txtsoexternal'];  
		$vsaleordentmp = $_REQUEST['txtsonumber']; // txtsonumber		
		$v5 = $_REQUEST['vhtxtrcgbwa']; ///$vidcustomer
		
		if ($v5=="")
		{
			//echo 
			$v5="FALSE";
		}
		$v6 = $_REQUEST['vhtxtmoden']; ///
		if ($v6=="")
		{
			//echo 
			$v6="FALSE";
		}
//		echo "a...".$v5."..b..".$v6;
		
		$v7 = $_REQUEST['dyhya']; // dyhya
		$v8 = $_REQUEST['txtdescripso']; //			
		$v13 = $_REQUEST['txtulgain']; //
		$v14 = $_REQUEST['txtulmaxpwr']; //
		$v15 = $_REQUEST['txtdlgain']; //
		$v16 = $_REQUEST['txtdlmaxpwr']; //		
		$v25 = $_SESSION["b"];
		$v26 = $_REQUEST['txtcant']; //		
		//$vtxtsn = $_REQUEST['txtsn']; //	
		$vlossnamodif= $_REQUEST['lossnamodif']; //	
		$porciones_sn = explode("#", $vlossnamodif);

		
	
		
		$v27 = $_REQUEST['txtnotepo']; //
		$v28 = $_REQUEST['txtdescripmatesp']; //
		$varray_LISTCHANNEL = $_REQUEST['templistchannel']; //
		$varray_LISTDPX = $_REQUEST['templistadpx']; //		
		$varray_LISTUNIT = $_REQUEST['templistagainuldl']; //
			
	
		$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->beginTransaction();
			 try {
					//$connect->query($sql);
						//Creamos la Revision....		
					
					 $query_lista ="insert into  orders SELECT idorders, idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, idrev + 1, idruninfo, date_approved, quantity, typeregister, processday, false, nameapproved ,'Y', ''	FROM orders 	where idorders = ".$vmaxid."  and idrev in (select max(idrev) from orders  where idorders = ".$vmaxid."   )";
					 $connect->query($query_lista);
					 
					 // buscamos la max rev.
					   $sql = $connect->prepare("select max(idrev) as maxidrev from orders  WHERE idorders = :vvidlog ");
					   $vvidpo = $vmaxid;
					$sql->bindParam(':vvidlog', $vvidpo);
					$sql->execute();
					$resultado = $sql->fetchAll();
					$vgeneradoidrev=0;
					foreach ($resultado as $row) 
					{
					///	echo "MAX ID REV ".$row['maxidrev']."---------------".$vvidpo;
					$vgeneradoidrev=$row['maxidrev']	;
					}
					 
					 
					 $query_lista ="insert into orders_sn SELECT idorders, idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, ".$vgeneradoidrev.", idnroserie, so_soft_external, wo_serialnumber, idruninfo, ponumber, pwrsupplytype, rcgfbwa, moden_dig, date_approved, descripcion, ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, nameapproved, notes, reqresources, typeregister, processday, false, so_original, so_associed
					FROM orders_sn 	where idorders = ".$vmaxid."  and idrev in (select max(idrev) from orders_sn  where idorders = ".$vmaxid."  )";
					$connect->query($query_lista);
				
					/// no debo copiar de la rev vieja. si mas abajo vamos a cargar los valores nuevos			
					//$query_lista ="insert into orders_sn_specs	SELECT idorders, ".$vgeneradoidrev.", idch, idnroserie, typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, notes
					//FROM orders_sn_specs 	where idorders = ".$vmaxid."  and idrev in (select max(idrev) from orders_sn_specs  where idorders = ".$vmaxid."   )";
					//$connect->query($query_lista);
				
					//y seguimos updateando
					
					foreach ($porciones_sn as $solounsn) 
					{
					//	echo "HOLA".$solounsn;
							$sentencia = $connect->prepare(" update orders_sn set pwrsupplytype = :pwrsupplytype, rcgfbwa = :rcgfbwa, moden_dig = :moden_dig, date_approved = now(),
							descripcion = :descripcion, ul_gain = :ul_gain, ul_max_pwr = :ul_max_pwr , dl_gain = :dl_gain, dl_max_pwr =:dl_max_pwr ,nameapproved=:nameapproved, 
							notes = :notes where idorders = ".$vmaxid." and idrev =  ".$vgeneradoidrev." and wo_serialnumber = '".$solounsn."'");
							$sentencia->bindParam(':pwrsupplytype', $v4);
							$sentencia->bindParam(':rcgfbwa', $v5);
							$sentencia->bindParam(':moden_dig', $v6);					
							$sentencia->bindParam(':descripcion', $v8);
							$sentencia->bindParam(':ul_gain', $v13);
							$sentencia->bindParam(':ul_max_pwr', $v14);
							$sentencia->bindParam(':dl_gain', $v15);
							$sentencia->bindParam(':dl_max_pwr', $v16);						
							$sentencia->bindParam(':nameapproved', $v25);	
												
							$sentencia->bindParam(':notes', $v27);	
							
							$sentencia->execute();
							/////////////////////////////////////////////////////////////////////////////////////
							//////AUDITAMOS///////////////////////////////////////////////////////////////////////////////
							$vuserfas = $_SESSION["b"];
							$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
							$vaccionweb="INSERT PO";
							$vdescripaudit="REPLICA PO NEW REV".$vgeneradoidrev;	
							$vtextaudit="insert y update into orders_sn SELECT idorders, idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, ".$vgeneradoidrev.", idnroserie, so_soft_external, wo_serialnumber, idruninfo, ponumber, pwrsupplytype, rcgfbwa, moden_dig, date_approved, descripcion, ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, nameapproved, notes, reqresources, typeregister, processday, processfasserver, so_original, so_associed FROM orders_sn 	where idorders = ".$vmaxid."  and idrev in (select max(idrev) from orders_sn  where idorders = ".$vmaxid."   )";
							$vtextaudit=$vtextaudit."!!idorders:".$vmaxid;
							$vtextaudit=$vtextaudit."!!idrev:".$vgeneradoidrev;						
							$vtextaudit=$vtextaudit."!!pwrsupplytype:".$v4;
							$vtextaudit=$vtextaudit."!!rcgfbwa:".$v5;
							$vtextaudit=$vtextaudit."!!moden_dig:".$v6;						
							$vtextaudit=$vtextaudit."!!descripcion:".$v8;
							$vtextaudit=$vtextaudit."!!ul_gain:".$v13;
							$vtextaudit=$vtextaudit."!!ul_max_pwr:".$v14;
							$vtextaudit=$vtextaudit."!!dl_gain:".$v15;
							$vtextaudit=$vtextaudit."!!dl_max_pwr:".$v16;
							
							$vtextaudit=$vtextaudit."!!nameapproved:".$v25;
							$vtextaudit=$vtextaudit."!!quantity:".$v26;
							$vtextaudit=$vtextaudit."!!notes:".$v27;
						
						
				
								$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();
					}
		
				
				   //Replicams configuracion para cada NROSErie   					
								 $query_lista ="insert into orders_sn_specs SELECT idorders, idrev+1, idch, idnroserie, typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop,  unitdlstart, unitdlstop, unitulstart, unitulstop, notes 
							FROM orders_sn_specs 	where idorders = ".$vmaxid." and idrev in (select max(idrev) from orders_sn_specs  where idorders = ".$vmaxid."   )";
						//	echo $query_lista;
							$connect->query($query_lista);
				
					
				/////////////////////////////////////////////////////////////////////////////////////
				foreach ($porciones_sn as $solounsn) 
				{
				/////////////////////////////////////////////////////////////////////////////////////
					///Insertamos los Channel
					//$varray_LISTCHANNEL
					
					
					 $porciones = explode("#", $varray_LISTCHANNEL);
					 $vidch=1;
					 $vtypedata="CHANNEL";
					   foreach($porciones as $elcanaluldl) {
							//echo "el canal:".$elcanaluldl;
							$separa_ULDL = explode("|", $elcanaluldl);
						//	echo "dL".$separa_ULDL[0]."--uL".$separa_ULDL[1]."<br>";
							if ($elcanaluldl <> "")
							{
								
							
								$vnotech  = $_REQUEST['txtnotechanel']; //
								// insetamos channel detalle PO
							///$sentenciach = $connect->prepare("INSERT INTO public.orders_sn_specs(idorders, idrev, idch, idnroserie, typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, notes)	VALUES (:idorders, :idrev, :idch, :idnroserie, :typedata, :ul_ch_fr, :dl_ch_fr, :dpxlowstart, :dpxlowstop, :dpxhihgstart, :dpxhihgstop, :unitdlstart, :unitdlstop, :unitulstart, :unitulstop, :notes);");
							$sentenciach = $connect->prepare("UPDATE orders_sn_specs SET ul_ch_fr=:ul_ch_fr , dl_ch_fr=:dl_ch_fr, dpxlowstart=:dpxlowstart, dpxlowstop=:dpxlowstop, dpxhihgstart=:dpxhihgstart, dpxhihgstop=:dpxhihgstop, unitdlstart=:unitdlstart, unitdlstop=:unitdlstop, unitulstart=:unitulstart, unitulstop=:unitulstop, notes=:notes where idorders = :idorders and idrev = :idrev and typedata = :typedata and idch = :idch and idnroserie IN ( select idnroserie from orders_sn where idorders = :idorders and wo_serialnumber = :idnroserie ) ");
								
								$sentenciach->bindParam(':idorders', $vmaxid);								
								$sentenciach->bindParam(':idrev', $vgeneradoidrev);
								$sentenciach->bindParam(':idch', $vidch);
								$sentenciach->bindParam(':idnroserie', $solounsn);
								$sentenciach->bindParam(':typedata', $vtypedata);
								$sentenciach->bindParam(':ul_ch_fr', $separa_ULDL[1]);
								$sentenciach->bindParam(':dl_ch_fr', $separa_ULDL[0]);
								$sentenciach->bindParam(':dpxlowstart', $vconcero);
								$sentenciach->bindParam(':dpxlowstop', $vconcero);
								$sentenciach->bindParam(':dpxhihgstart', $vconcero);
								$sentenciach->bindParam(':dpxhihgstop', $vconcero);
								$sentenciach->bindParam(':unitdlstart', $vconcero);
								$sentenciach->bindParam(':unitdlstop', $vconcero);
								$sentenciach->bindParam(':unitulstart', $vconcero);
								$sentenciach->bindParam(':unitulstop', $vconcero);
								
							
								$sentenciach->bindParam(':notes', $vnotech);
								
								$sentenciach->execute();
								/////////////////////////////////////////////////////////////////////////////////////
								/////////////////////////////////////////////////////////////////////////////////////								
														
								
								/////////////////////////////////////////////////////////////////////////////////////
								/////////////////////////////////////////////////////////////////////////////////////	
									
								$vidch = $vidch + 1 ;	
							}
							
						}
					 //$varray_LISTDPX
					 $porciones = explode("#", $varray_LISTDPX);
					 $vidchdpx=1;
					 $vtypedata="DPX";
					   foreach($porciones as $elcanaluldl) {
							//echo "el canal:".$elcanaluldl;
							$separa_DPX  = explode("|", $elcanaluldl);
							//echo "low".$separa_DPX[0]."--".$separa_DPX[1]."<br>";
							if ($elcanaluldl <> "")
							{
								// insetamos channel detalle PO
									$vnotech  = $_REQUEST['txtnotedpc']; //
									
								$sentenciach = $connect->prepare("UPDATE orders_sn_specs SET ul_ch_fr=:ul_ch_fr , dl_ch_fr=:dl_ch_fr, dpxlowstart=:dpxlowstart, dpxlowstop=:dpxlowstop, dpxhihgstart=:dpxhihgstart, dpxhihgstop=:dpxhihgstop, unitdlstart=:unitdlstart, unitdlstop=:unitdlstop, unitulstart=:unitulstart, unitulstop=:unitulstop, notes=:notes where idorders = :idorders and idrev = :idrev and typedata = :typedata and idch = :idch and idnroserie IN ( select idnroserie from orders_sn where idorders = :idorders and wo_serialnumber = :idnroserie ) ");
							$sentenciach->bindParam(':idorders', $vmaxid);								
								$sentenciach->bindParam(':idrev', $vgeneradoidrev);
								$sentenciach->bindParam(':idch', $vidchdpx);
								$sentenciach->bindParam(':idnroserie', $solounsn);
								$sentenciach->bindParam(':typedata', $vtypedata);								
								$sentenciach->bindParam(':ul_ch_fr', $vconcero);
								$sentenciach->bindParam(':dl_ch_fr', $vconcero);
								$sentenciach->bindParam(':dpxlowstart', $separa_DPX[0]);
								$sentenciach->bindParam(':dpxlowstop', $separa_DPX[1]);
								$sentenciach->bindParam(':dpxhihgstart',$separa_DPX[2]);
								$sentenciach->bindParam(':dpxhihgstop', $separa_DPX[3]);
								$sentenciach->bindParam(':unitdlstart', $vconcero);
								$sentenciach->bindParam(':unitdlstop', $vconcero);
								$sentenciach->bindParam(':unitulstart', $vconcero);
								$sentenciach->bindParam(':unitulstop', $vconcero);
									$sentenciach->bindParam(':notes', $vnotech);
								$sentenciach->execute();
								
								/////////////////////////////////////////////////////////////////////////////////////
								/////////////////////////////////////////////////////////////////////////////////////								
													
								
								/////////////////////////////////////////////////////////////////////////////////////
								/////////////////////////////////////////////////////////////////////////////////////	
									
								$vidchdpx = $vidchdpx + 1 ;	
							}
							
						}
						//$varray_LISTUNIT
					 $porciones = explode("#", $varray_LISTUNIT);
					 $vidchunit=1;
					 $vtypedata="UNIT";
					   foreach($porciones as $elcanaluldl) {
							//echo "el canal:".$elcanaluldl;
							$separa_UNIT  = explode("|", $elcanaluldl);
							//echo "low".$separa_UNIT[0]."--".$separa_UNIT[1]."<br>";
							if ($elcanaluldl <> "")
							{
								// insetamos channel detalle PO
								$vnotech  = $_REQUEST['txtnotedpc']; //
							$sentenciach = $connect->prepare("UPDATE orders_sn_specs SET ul_ch_fr=:ul_ch_fr , dl_ch_fr=:dl_ch_fr, dpxlowstart=:dpxlowstart, dpxlowstop=:dpxlowstop, dpxhihgstart=:dpxhihgstart, dpxhihgstop=:dpxhihgstop, unitdlstart=:unitdlstart, unitdlstop=:unitdlstop, unitulstart=:unitulstart, unitulstop=:unitulstop, notes=:notes where  idorders = :idorders and idrev = :idrev and typedata = :typedata and idch = :idch and idnroserie IN ( select idnroserie from orders_sn where idorders = :idorders and wo_serialnumber = :idnroserie ) ");
							$sentenciach->bindParam(':idorders', $vmaxid);								
								$sentenciach->bindParam(':idrev', $vgeneradoidrev);
								$sentenciach->bindParam(':idch', $vidchunit);
								$sentenciach->bindParam(':idnroserie', $solounsn);
								$sentenciach->bindParam(':typedata', $vtypedata);
								$sentenciach->bindParam(':ul_ch_fr', $vconcero);
								$sentenciach->bindParam(':dl_ch_fr', $vconcero);
								$sentenciach->bindParam(':dpxlowstart', $vconcero);
								$sentenciach->bindParam(':dpxlowstop', $vconcero);
								$sentenciach->bindParam(':dpxhihgstart',$vconcero);
								$sentenciach->bindParam(':dpxhihgstop', $vconcero);
								$sentenciach->bindParam(':unitdlstart', $separa_UNIT[0]);
								$sentenciach->bindParam(':unitdlstop', $separa_UNIT[1]);
								$sentenciach->bindParam(':unitulstart',$separa_UNIT[2]);
								$sentenciach->bindParam(':unitulstop', $separa_UNIT[3]);
									$sentenciach->bindParam(':notes', $vnotech);
								$sentenciach->execute();
								
								/////////////////////////////////////////////////////////////////////////////////////
								/////////////////////////////////////////////////////////////////////////////////////								
													
								
								/////////////////////////////////////////////////////////////////////////////////////
								/////////////////////////////////////////////////////////////////////////////////////	
									
								$vidchunit = $vidchunit + 1 ;	
							}
							
					   }	
						
					///fin for de cant de Sn a modificar	
					  } 
					
							
							
						
					//	$query_lista ="INSERT INTO presales_states(idpresales, idstate, datestate)	VALUES (".$vmaxid.", 1, now());";
					// $connect->query($query_lista);
					///Notificaciones
					$msjalertglobo="New Revision SO: ".$vtxtsoexternal."";
						$msjlink="listpresales.php";
						$query_lista2 ="INSERT INTO notices_users select ( select count(idnotice)+1 from notices_users), ".$_SESSION["a"].",".$_SESSION["i"].", now(), null, '$msjalertglobo', '$msjlink'";						
						$connect->query($query_lista2);
						//aviso leo
						$query_lista2 ="INSERT INTO notices_users select ( select count(idnotice)+1 from notices_users), 2,".$_SESSION["i"].", now(), null, '$msjalertglobo', '$msjlink'";						
						$connect->query($query_lista2);
						// aviso marco
						$query_lista2 ="INSERT INTO notices_users select ( select count(idnotice)+1 from notices_users), 17,".$_SESSION["i"].", now(), null, '$msjalertglobo', '$msjlink'";						
						$connect->query($query_lista2);
						
						// aviso diego m
						$query_lista2 ="INSERT INTO notices_users select ( select count(idnotice)+1 from notices_users), 16,".$_SESSION["i"].", now(), null, '$msjalertglobo', '$msjlink'";						
						$connect->query($query_lista2);
						
						// aviso diego Luciana
						$query_lista2 ="INSERT INTO notices_users select ( select count(idnotice)+1 from notices_users), 11,".$_SESSION["i"].", now(), null, '$msjalertglobo', '$msjlink'";						
						$connect->query($query_lista2);
						
						// aviso albert
						$query_lista2 ="INSERT INTO notices_users select ( select count(idnotice)+1 from notices_users), 20,".$_SESSION["i"].", now(), null, '$msjalertglobo', '$msjlink'";						
						$connect->query($query_lista2);
					// fin notificaciones
					
							$vdescripaudit="NEW REG presales_states  -  notices_users ".$msjalertglobo;		
								$vtextaudit="INSERT notices_users new rev po ".$vmaxid." users in(1,2,17,16,11,20,)";
						
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();		
					
					$return_result_insert="ok";
				    $connect->commit();
					?>
				

					<html>
					<p></p>
					</html>
					<script src="plugins/jquery/jquery.min.js"></script>
					<!-- Bootstrap 4 -->		
				
					
					<link rel="stylesheet" href="sweetalert2/msweetalert2.min.css">
					<script src="sweetalert2/msweetalert2.min.js"></script>
					
					<script >
					Swal.fire({
							  title: 'SO Saved!',
							  
							  icon: 'success',
							  showCancelButton: false,
							  confirmButtonColor: '#3085d6',							  
							  confirmButtonText: 'OK',							  
							}).then((result) => {
							  if (result.value) 
							  {
								window.location="saleorders.php"; 
							  }
							  else
							  {
								 window.location="saleorders.php";
							  }
							})

					</script>
					<?php
					exit();
				} 
				catch (PDOException $e) 
				{
					$connect->rollBack();
					$return_result_insert="error".$e->getMessage();
					$msjerr= "Syntax Error MM: ".$e->getMessage();
					echo $msjerr;
					exit();
				}
	}
	
	
	///// FIN PROCESAMOS EL POST POR LA NEW REVISION

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
  
  
  <link href="css/tabulator_bootstrap4.css" rel="stylesheet">
  <link rel="shortcut icon" href="fiplexcirculo-01.ico" />
  
  <link rel="stylesheet" href="toastr.css">
  
 <link href="css/tabulator_bulma.css" rel="stylesheet">
 
  
    <link rel="stylesheet" href="cssfiplex.css">
	
		<style>
	body
{
  font-family: Arial, Helvetica, sans-serif;
  font-size:12px;
}
a:link {
  color:#000000;
}

a:visited {
 color:#000000;
}

a:hover {
  color:#000000;
}

a:active {
 color:#000000;
}

.card-headermarco
{
	  font-family: Arial, Helvetica, sans-serif;
  font-size:14px;
  border-style: solid;
  border-color:#ffffff;
  border-width: 1px;
}

.example1_wrapper
{
 border-style: solid; 
  border-width: 2px;	
}

textarea.form-control {
    height: 100%;
}

  .select-wrapper {
        margin: auto;
        max-width: 600px;
        width: calc(100% - 40px);
      }

      .select-pure__select {
        align-items: center;
        background: #f9f9f8;
        border-radius: 4px;
        border: 1px solid rgba(0, 0, 0, 0.15);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        box-sizing: border-box;
        color: #363b3e;
        cursor: pointer;
        display: flex;
        font-size: 16px;
        font-weight: 500;
        justify-content: left;
        min-height: 44px;
        padding: 5px 10px;
        position: relative;
        transition: 0.2s;
        width: 100%;
      }

      .select-pure__options {
        border-radius: 4px;
        border: 1px solid rgba(0, 0, 0, 0.15);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        box-sizing: border-box;
        color: #0053a1; /* #363b3e;*/
        display: none;
        left: 0;
        max-height: 221px;
        overflow-y: scroll;
        position: absolute;
        top: 50px;
        width: 100%;
        z-index: 5;
      }

      .select-pure__select--opened .select-pure__options {
        display: block;
      }

      .select-pure__option {
        background: #fff;
        border-bottom: 1px solid #e4e4e4;
        box-sizing: border-box;
        height: 44px;
        line-height: 25px;
        padding: 10px;
      }

      .select-pure__option--selected {
        color: #e4e4e4;
        cursor: initial;
		 text-decoration:line-through;
        pointer-events: none;
      }

      .select-pure__option--hidden {
        display: none;
      }

      .select-pure__selected-label {
        align-items: 'center';
        background: #0053a1;  /*#5e6264;*/
        border-radius: 4px;
        color: #fff;
        cursor: initial;
        display: inline-flex;
        justify-content: 'center';
        margin: 5px 10px 5px 0;
        padding: 3px 7px;
      }

      .select-pure__selected-label:last-of-type {
        margin-right: 0;
      }

      .select-pure__selected-label i {
        cursor: pointer;
        display: inline-block;
        margin-left: 7px;
      }

      .select-pure__selected-label img {
        cursor: pointer;
        display: inline-block;
        height: 18px;
        margin-left: 7px;
        width: 14px;
      }

      .select-pure__selected-label i:hover {
        color: #e4e4e4;
      }

      .select-pure__autocomplete {
        background: #f9f9f8;
        border-bottom: 1px solid #e4e4e4;
        border-left: none;
        border-right: none;
        border-top: none;
        box-sizing: border-box;
        font-size: 16px;
        outline: none;
        padding: 10px;
        width: 100%;
      }

      .select-pure__placeholder--hidden {
        display: none;
      }
	  
</style>


</head>

<form  action="saleorders_rma.php" method="post" class="form-horizontal" id="myform" name="myform">	
<input class="form-control" id="poselecm" type="hidden" name="poselecm">
<input class="form-control" id="permiso_print_label_flex" type="hidden" name="permiso_print_label_flex" value="<?php echo $permiso_print_label_flex; ?>">

					<input class="form-control" id="poselecmrev" type="hidden" name="poselecmrev">
<input type="hidden" name="uso" id="uso" value="0">
<input type="hidden" name="so_del_rma" id="so_del_rma" value="0">
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
        <a href="http://srv-pgsql.fiplex.com/index.php" class="nav-link">Home</a>
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
            <h1>RMA - Sales Orders </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">RMA - Sales Orders</li>
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
          <section class="col-lg-6 connectedSortable ui-sortable">

            <div class="" name="divscrolllog" id="divscrolllog" style="display.">
			
			  <div class="demo-container">
  
			
			
			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				<div class="card">
						<div id="accordion">
					<br>			
					<table id="example1" class="table table-sm table-striped">
						<thead>
						<tr style="background-color:#3c3c3b;color:#aaaaaa">                  
						  <th style='color:#aaaaaa'>SO - Customers
						 <span name="openbusqueda" id="openbusqueda" > &nbsp; &nbsp; &nbsp;<a href="#" onclick="habilitarbusqueda();"><i class="fas fas fa-search-plus mr-1" style='color:#aaaaaa' ></i></a></span>
						 <span name="closebusqueda" id="closebusqueda"> &nbsp; &nbsp; &nbsp;<a href="#" onclick="dehabilitarbusqueda();"><i class="fas fas  fa-search-minus mr-1" style='color:#aaaaaa' ></i></a></span>
						  
					
						
						  </th>   
						</tr>
						</thead>
						<tbody>
					  
							
								<?php		

							
							  		   $query_lista = list_SO_count_report1_RMA();	
									//	echo $query_lista;									   
										$data = $connect->query($query_lista)->fetchAll();		

									$lblbusquedarapida="";
  
									//echo  $query_lista;
										foreach ($data as $row) 
										{
											$qporc=round(($row[3]*100)/$row[2]);
												  $bgclass="bg-red";
												  $lblbusquedarapida="No actions";
											      if ( $row['cantdib'] >1)
												  {
													      $bgclass="bg-warning";
														  $lblbusquedarapida="Dig. Mod Executed";
												  }
												  if ( $row['cantcalib']   >1)												  {
													
													  $bgclass="bg-info";
													  $lblbusquedarapida="Calibration Executed  ";
												  }
												  if ($row['cantfinalchk'] > 1)
												  {
													    $bgclass="bg-green";
														$lblbusquedarapida="FinalChk Executed";
												  }
												  $v_show_SO_CIU = $row[1];
											?>
												<tr>                  
												  <td>
													
														                   
															<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $row[0]; ?>" class="" aria-expanded="true" onclick="show_ciu('<?php echo $row[0]; ?>','<?php echo $v_show_SO_CIU; ?>')">
																
															  <i class="nav-icon fas fa-list-alt"></i>
															<?php
																$xnom = str_replace('#', ' ', substr($row[4],0,30)); 
																 //echo  " ".$row[1]." - ".substr($row[4],0,30); 
																 echo  " ".$row[1]." - ".$xnom;
																if ( strlen($row[4])>31) 
															    { 
																 echo "...";
																} 
															
																?> 
																
																
																</a>
														  
														
														  
																<span data-toggle="tooltip" title="" class="badge <?php echo $bgclass; ?>  mb-2 labelsom ">										
																   <?php echo " [ ".$row[2]; ?> CIU ]
																																
																</span> 			
																														
																			
														
														<div id="collapse<?php echo $row[0]; ?>" class="panel-collapse in collapse" style="background-color:#ffffff">
														<span class="textooculto" style="display:none">
															<?php echo "###".$row['groupxciu']."###".$row['groupxsn']."###".$row[0]."###".$row[1]."###".$lblbusquedarapida."###"; ?>
															</span>
														<table id="example3" class="table table-bordered table-striped table-sm">
														<tbody><tr><td>
															<div class="card-headermarco">
															
																
														    </div>
														</td></tr>	</tbody></table>
														</div>
															
														
												  </td>	
												</tr>														
											<?php
										}
										//////Agregamos aca los nuevos SO generados desde PO y WO ///										
											
										  $query_lista = "select  distinct orders_sn.so_soft_external,  namecustomers , pre.idorders,pre.idrev, count(distinct  products.modelciu ) as cc_ciu
										  ,  array_agg(coalesce(wo_serialnumber,'')) as groupxsn, array_agg(coalesce(modelciu,'')) as groupxciu
from orders as pre
inner join products
on products.idproduct = pre.idproduct  												
inner join customers
on customers.idcustomers = pre.idcustomers
inner join orders_states as  prestatus 
on prestatus.idorders = pre.idorders 
 inner join 
													(
														select idorders, max(idrev) as maxiderev from orders
														group by idorders
													) as maxidrevxpo
													on maxidrevxpo.idorders  = pre.idorders and 
													   maxidrevxpo.maxiderev =  pre.idrev	 													  
inner join orders_sn
on orders_sn.idorders = pre.idorders 
where pre.typeregister = 'SO' and pre.active ='Y' and orders_sn.wo_serialnumber <> ' ' and orders_sn.so_associed  <> ' '  
and  orders_sn.so_soft_external like '%RM'
group by orders_sn.so_soft_external,  namecustomers , pre.idorders,pre.idrev

order by so_soft_external";
									//	echo $query_lista;			
/// and orders_sn.so_soft_external like '%SO'									
										$data = $connect->query($query_lista)->fetchAll();		

									$lblbusquedarapida="";
  
									//echo  $query_lista;
										foreach ($data as $row) 
										{
											 $idpresales =  $row['idorders'];
											 $vidrev =  $row['idrev'];
											 
											// $idruninfo = $Encryption->encrypt($row['idruninfo'], $semillafp); // $row['idruninfo'];
											$so_soft_external = $row['so_soft_external'];     
											$date_approved = substr($row['datestate'],5,5);
											$date_approved_t = substr($row['datestate'],11,5);
											$ponumber =  sprintf("%'.09d\n",$row['ponumber']); 
											$ponumber = $row['ponumber'];
											$ciu = $row['ciu'];  
											$quantity = $row['quantity'];  
											$namecustomers = $row['namecustomers']; 
											$cortonamecustomers = substr($row['namecustomers'],0,10).".."; 
											$idstates = $row['idstates']; 
								
											$qporc=round(($row[3]*100)/$row[2]);
												  $bgclass="bg-red";
												  $lblbusquedarapida="No actions";
											      if ( $row['cantdib'] >1)
												  {
													      $bgclass="bg-warning";
														  $lblbusquedarapida="Dig. Mod Executed";
												  }
												  if ( $row['cantcalib']   >1)												  {
													
													  $bgclass="bg-info";
													  $lblbusquedarapida="Calibration Executed  ";
												  }
												  if ($row['cantfinalchk'] > 1)
												  {
													    $bgclass="bg-green";
														$lblbusquedarapida="FinalChk Executed";
												  }
												  $v_show_SO_CIU = $row[1];
											?>
												<tr>                  
												  <td>
													
														                   
															<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $idpresales; ?>" class="" aria-expanded="true" onclick="show_ciu_version2020('<?php echo $idpresales; ?>','<?php echo $v_show_SO_CIU; ?>')">
																
															  <i class="nav-icon fas fa-sliders-h"></i>
															<?php
																$xnom = str_replace('#', ' ', substr($namecustomers,0,30)); 
																 //echo  " ".$row[1]." - ".substr($row[4],0,30); 
																 echo  "** ".$so_soft_external." - ".$xnom;
																if ( strlen($namecustomers)>31) 
															    { 
																 echo "...";
																} 
															
																?> 
																
																
																</a>
														  
														
														  
																<span data-toggle="tooltip" title="" class="badge <?php echo $bgclass; ?>  mb-2 labelsom ">										
																   <?php echo " [ ".$row['cc_ciu']; ?> CIU ]
																																
																</span> 			
																
																			
														
														<div id="collapse<?php echo $idpresales; ?>" class="panel-collapse in collapse" style="background-color:#ffffff">
														<span class="textooculto" style="display:none">
															<?php echo "###".$row['groupxciu']."###".$row['groupxsn']."###".$row[0]."###".$row[1]."###".$lblbusquedarapida."###"; ?>
															</span>
														<table id="example3" class="table table-bordered table-striped table-sm">
														<tbody><tr><td>
															<div class="card-headermarco">
															
																
														    </div>
														</td></tr>	</tbody></table>
														</div>
															
														
												  </td>	
												</tr>														
											<?php
										}
											
										///// FIN Agregamos aca los nuevos SO generados desde PO y WO ///
											?>			
							
                  <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
							
						</tbody>
					  </table>
					  <span class="pull-right-container">
			<span >&nbsp <b>Color reference:</b></span>
			  <small class="badge pull-right bg-red">No actions</small>
              <small class="badge pull-right bg-yellow">Dig. Mod Executed</small>
              <small class="badge pull-right bg-info">Calibration Executed</small>
              <small class="badge	 pull-right bg-green">FinalChk Executed</small>
            </span>
					</div>				  
				</div>	
				</div>
			
					

        </section>
		<section class="col-lg-6 connectedSortable ui-sortable">
		

				<div class="card">
				<div class="card-header ui-sortable-handle" >
               		
				<div class="card">
            
              <!-- /.card-header -->
              <div class="card-body p-0" style="display: block;">
                <div class="d-md-flex">
                  <div class="p-1 flex-fill" style="overflow: hidden" >
                    
					
					<!--detalle so -->
					<div class="card" style="position: relative; left: 0px; top: 0px;">
              <div class="card-header ui-sortable-handle" >
                <h3 class="card-title">
                  <i class="fas fas fa-tag mr-1"></i>
                  General Info - Details: 
				  <p name="ciusnshowbks" id="ciusnshowbks" class="d-none "> 
                </h3><p name="ciusnshow" id="ciusnshow" class="text-primary ">  </p>
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item" name="divgeneralinfo" id="divgeneralinfo">
                      <a class="nav-link active" href="#generalinfo" data-toggle="tab">General Info</a>
                    </li>
					<li class="nav-item" name="divgeneralinfoparam" id="divgeneralinfoparam">
                      <a class="nav-link" href="#generalinfoul" data-toggle="tab">Parameters</a>
                    </li>
					
                    <li class="nav-item" name="divdetinfolog" id="divdetinfolog">
                      <a class="nav-link " href="#infolog" data-toggle="tab">Details Log</a>
                    </li>  
					
					 <li class="nav-item" name="diveq" id="diveq">
                      <a class="nav-link " href="#div_calib_eq" data-toggle="tab">EQ</a>
                    </li> 
					<li class="nav-item" name="divfactory" id="divfactory">
                      <a class="nav-link " href="#div_calib_fact" data-toggle="tab">Factory</a>
                    </li> 
					<li class="nav-item" name="divfinalcheck" id="divfinalcheck">
                      <a class="nav-link " href="#div_calib_finalcheck" data-toggle="tab">Final Check</a>
                    </li> 
					<li class="nav-item" name="divscripttime" id="divscripttime">
                      <a class="nav-link " href="#div_scripttime" data-toggle="tab">Script Times</a>
                    </li> 
					<li class="nav-item" name="diveditparamciu" id="diveditparamciu">
                      <a class="nav-link " href="#div_diveditparamciu" name="editciusn" id="editciusn" data-toggle="tab">Edit Parameters</a>
                    </li> 
						
						
					<li class="nav-item" name="divgroupbyciu" id="divgroupbyciu">
                      <a class="nav-link " href="#infogroupbyciu" data-toggle="tab">Group by CIU</a>
                    </li>
                  </ul>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
				  <div class="chart tab-pane pre-scrollablemarco  " id="infogroupbyciu" style="position: relative; ">
				  
				  
					--
				  </div>
				   <div class="chart tab-pane pre-scrollablemarco " id="generalinfoul" style="position: relative; ">
				     <table id="myTableul"  border="1" class="table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none">							
							  <tr data-rowul="0" >
								<td data-rowul="0" data-colul="0" align='center'><B>PARAMETERS<B> </td>								
							  </tr>
							  <tr data-rowdl="1">
								<td data-rowul="1" data-colul="0"><b>Gain:</b> </td>								
							  </tr>
							  <tr data-rowul="2">
								<td data-rowul="2" data-colul="0"><b>Max Pwr:</b> </td>								
							  </tr>
							  <tr data-rowul="3">
								<td data-rowul="3" data-colul="0"><b>Freq Start:</b> </td>								
							  </tr>
							  <tr data-rowul="4">
								<td data-rowul="4" data-colul="0"><b>Freq Stop:</b> </td>								
							  </tr> 
							   
							</table>
							
							<table id='myTablesubband' border='1' class='table table-bordered table-sm texto10 table-striped  scrolltablemarco d-none'>
							<tr data-rowsubband='0'><td data-rowsubband='0' data-colsubband='0'><B>SUB BAND<B> </td></tr>
							<tr data-rowsubband='1'><td data-rowsubband='1' data-colsubband='0'><b>Start:</b></td></tr>
							<tr data-rowsubband='2'><td data-rowsubband='2' data-colsubband='0'><b>Center:</b></td></tr>
							<tr data-rowsubband='3'><td data-rowsubband='3' data-colsubband='0'><b>Stop:</b></td></tr>
							
							</table>
							
							<table id='myTablechanel' border='1' class='table table-bordered table-sm texto10 table-striped  scrolltablemarco d-none'>
							<tr data-rowchanel='0'><td data-rowchanel='0' data-colchanel='0'><B>FREC. CH.<B></td></tr>
							<tr data-rowchanel='1'><td data-rowchanel='1' data-colchanel='0'><b>FCh[0]:</b></td></tr>
							<tr data-rowchanel='2'><td data-rowchanel='2' data-colchanel='0'><b>FCh[1]:</b></td></tr>
							<tr data-rowchanel='3'><td data-rowchanel='3' data-colchanel='0'><b>FCh[2]:</b></td></tr>
							<tr data-rowchanel='4'><td data-rowchanel='4' data-colchanel='0'><b>FCh[3]:</b></td></tr>
							<tr data-rowchanel='5'><td data-rowchanel='5' data-colchanel='0'><b>FCh[4]:</b></td></tr>
							<tr data-rowchanel='6'><td data-rowchanel='6' data-colchanel='0'><b>FCh[5]:</b></td></tr>
							<tr data-rowchanel='7'><td data-rowchanel='7' data-colchanel='0'><b>FCh[6]:</b></td></tr>
							<tr data-rowchanel='8'><td data-rowchanel='8' data-colchanel='0'><b>FCh[7]:</b></td></tr>
							<tr data-rowchanel='9'><td data-rowchanel='9' data-colchanel='0'><b>FCh[8]:</b></td></tr>
							<tr data-rowchanel='10'><td data-rowchanel='10' data-colchanel='0'><b>FCh[9]:</b></td></tr>
							<tr data-rowchanel='11'><td data-rowchanel='11' data-colchanel='0'><b>FCh[11]:</b></td></tr>							
							<tr data-rowchanel='12'><td data-rowchanel='12' data-colchanel='0'><b>FCh[12]:</b></td></tr>
							<tr data-rowchanel='13'><td data-rowchanel='13' data-colchanel='0'><b>FCh[13]:</b></td></tr>
							<tr data-rowchanel='14'><td data-rowchanel='14' data-colchanel='0'><b>FCh[14]:</b></td></tr>
							<tr data-rowchanel='15'><td data-rowchanel='15' data-colchanel='0'><b>FCh[15]:</b></td></tr>
							<tr data-rowchanel='16'><td data-rowchanel='16' data-colchanel='0'><b>FCh[16]:</b></td></tr>
							<tr data-rowchanel='17'><td data-rowchanel='17' data-colchanel='0'><b>FCh[17]:</b></td></tr>
							<tr data-rowchanel='18'><td data-rowchanel='18' data-colchanel='0'><b>FCh[18]:</b></td></tr>
							<tr data-rowchanel='19'><td data-rowchanel='19' data-colchanel='0'><b>FCh[19]:</b></td></tr>
							<tr data-rowchanel='20'><td data-rowchanel='20' data-colchanel='0'><b>FCh[20]:</b></td></tr>
							<tr data-rowchanel='21'><td data-rowchanel='21' data-colchanel='0'><b>FCh[21]:</b></td></tr>
							<tr data-rowchanel='22'><td data-rowchanel='22' data-colchanel='0'><b>FCh[22]:</b></td></tr>
							<tr data-rowchanel='23'><td data-rowchanel='23' data-colchanel='0'><b>FCh[23]:</b></td></tr>
							<tr data-rowchanel='24'><td data-rowchanel='24' data-colchanel='0'><b>FCh[24]:</b></td></tr>
							<tr data-rowchanel='25'><td data-rowchanel='25' data-colchanel='0'><b>FCh[25]:</b></td></tr>
							<tr data-rowchanel='26'><td data-rowchanel='26' data-colchanel='0'><b>FCh[26]:</b></td></tr>
							<tr data-rowchanel='27'><td data-rowchanel='27' data-colchanel='0'><b>FCh[27]:</b></td></tr>
							<tr data-rowchanel='28'><td data-rowchanel='28' data-colchanel='0'><b>FCh[28]:</b></td></tr>
							<tr data-rowchanel='29'><td data-rowchanel='29' data-colchanel='0'><b>FCh[29]:</b></td></tr>
							<tr data-rowchanel='30'><td data-rowchanel='30' data-colchanel='0'><b>FCh[30]:</b></td></tr>
							
							</table>
							
							
				   </div>
				
                  <div class="chart tab-pane active pre-scrollablemarco " id="generalinfo" style="position: relative;">
                  	
							<table id='myTable'  class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'><tr data-row='0'><td data-row='0' data-col='0'></td></tr><tr data-row='1'><td data-row='1' data-col='0'><b>Approved:</b> </td></tr><tr data-row='2'><td data-row='2' data-col='0'><b>Power Supply:PO:</b> </td> </tr><tr data-row='3'><td data-row='3' data-col='0'><b>PO:</b></td></tr><tr data-row='4'><td data-row='4' data-col='0'><b>RC-G for BWA:</b> </td></tr><tr data-row='5'><td data-row='5' data-col='0'><b>Modem Digital:</b></td></tr><tr data-row='6'><td data-row='6' data-col='0'><b>Descripcion:</b> </td></tr></table>
							
							<table id='myTabledib' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'>
							<tr data-rowdib='0'><td data-rowdib='0' data-coldib='0' class='table-info'><b>GENERAL INFO</b> </td></tr>
							<tr data-rowdib='1'><td data-rowdib='1' data-coldib='0'>Date</td></tr>
							<tr data-rowdib='2'><td data-rowdib='2' data-coldib='0'>TotalTime </td></tr>
							<tr data-rowdib='3'><td data-rowdib='3' data-coldib='0'>Calibratior </td></tr>
							<tr data-rowdib='4'><td data-rowdib='4' data-coldib='0'>Station</td></tr>
							<tr data-rowdib='5'><td data-rowdib='5' data-coldib='0'>FAS</td></tr>
							<tr data-rowdib='6'><td data-rowdib='6' data-coldib='0'>Total Pass </td></tr>	
														
							</table>
							<table id='myTabledibfw' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'>
							<tr data-rowdibfw='0'><td data-rowdibfw='0' data-coldibfw='0' class="table-info"><b>FWs</b> </td></tr>
							<tr data-rowdibfw='1'><td data-rowdibfw='1' data-coldibfw='0'>FW FPGA</td></tr>
							<tr data-rowdibfw='2'><td data-rowdibfw='2' data-coldibfw='0'>FW uC </td></tr>
							<tr data-rowdibfw='3'><td data-rowdibfw='3' data-coldibfw='0'>FW Rabb </td></tr>							
							</table>
							<table id='myTabledibsn' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none '>
							<tr data-rowdibsn='0'><td data-rowdibsn='0' data-coldibsn='0' class="table-info"><b>SNs</b> </td></tr>
							<tr data-rowdibsn='1'><td data-rowdibsn='1' data-coldibsn='0'>SN DB</td></tr>
							<tr data-rowdibsn='2'><td data-rowdibsn='2' data-coldibsn='0'>SN Unit </td></tr>							
							</table>
							<table id='myTabledibciu' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'>
							<tr data-rowdibciu='0'><td data-rowdibciu='0' data-coldibciu='0' class="table-info"><b>CIUs</b> </td></tr>
							<tr data-rowdibciu='1'><td data-rowdibciu='1' data-coldibciu='0'>CIU DB</td></tr>
							<tr data-rowdibciu='2'><td data-rowdibciu='2' data-coldibciu='0'>CIU Unit </td></tr>							
							</table>
							
							<table id='myTablecaliffw' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'>
							<tr data-rowcaliffw='0'><td data-rowcaliffw='0' data-colcaliffw='0' class="table-info"><b>FWs</b> </td></tr>
							<tr data-rowcaliffw='1'><td data-rowcaliffw='1' data-colcaliffw='0'>FW FPGA</td></tr>
							<tr data-rowcaliffw='2'><td data-rowcaliffw='2' data-colcaliffw='0'>FW uC </td></tr>
							<tr data-rowcaliffw='3'><td data-rowcaliffw='3' data-colcaliffw='0'>FW Rabb </td></tr>
							<tr data-rowcaliffw='4'><td data-rowcaliffw='4' data-colcaliffw='0'>FW PAHP </td></tr>														
							</table>
							
							<table id='myTablecalifsn' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none '>
							<tr data-rowcalifsn='0'><td data-rowcalifsn='0' data-colcalifsn='0' class="table-info"><b>SNs</b> </td></tr>
							<tr data-rowcalifsn='1'><td data-rowcalifsn='1' data-colcalifsn='0'>SN DB</td></tr>
							<tr data-rowcalifsn='2'><td data-rowcalifsn='2' data-colcalifsn='0'>SN Unit </td></tr>							
							<tr data-rowcalifsn='3'><td data-rowcalifsn='3' data-colcalifsn='0'>SN PALP </td></tr>							
							<tr data-rowcalifsn='4'><td data-rowcalifsn='4' data-colcalifsn='0'>SN PAHP </td></tr>							
							</table>
							
							<table id='myTablecalifciu' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'>
							<tr data-rowcalifciu='0'><td data-rowcalifciu='0' data-colcalifciu='0' class="table-info"><b>CIUs</b> </td></tr>
							<tr data-rowcalifciu='1'><td data-rowcalifciu='1' data-colcalifciu='0'>CIU DB</td></tr>
							<tr data-rowcalifciu='2'><td data-rowcalifciu='2' data-colcalifciu='0'>CIU Unit </td></tr>	
							<tr data-rowcalifciu='3'><td data-rowcalifciu='3' data-colcalifciu='0'>CIU PALP</td></tr>
							<tr data-rowcalifciu='4'><td data-rowcalifciu='4' data-colcalifciu='0'>CIU PAHP </td></tr>								
							</table>
							
							<table id='myTablecaliffreq' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped d-none '>
							<tr data-rowccaliffreq='0'><td data-rowcaliffreq='0' data-colcaliffreq='0' class="table-info"><b>Freqs</b> </td></tr>
							<tr data-rowcaliffreq='1'><td data-rowcaliffreq='1' data-colcaliffreq='0'>UL Start</td></tr>
							<tr data-rowcaliffreq='2'><td data-rowcaliffreq='2' data-colcaliffreq='0'>UL Stop </td></tr>	
							<tr data-rowcaliffreq='3'><td data-rowcaliffreq='3' data-colcaliffreq='0'>DL Start</td></tr>
							<tr data-rowcaliffreq='4'><td data-rowcaliffreq='4' data-colcaliffreq='0'>DL Stop </td></tr>								
							</table>
							
							   <div  id="generalinfocalib"  name="generalinfocalib" style="position: relative;">
								</div>			
                   </div>
                  <div class="chart tab-pane pre-scrollablemarco d-none" id="infolog" style="position: relative;">
				  <button type="button" class="btn btn-sm "><i class="fas fa-search"></i> Rev 0</button>	  
				    
				  
				  
				  <textarea class="form-control" rows="18" id="detallelog" name="detallelog"></textarea>
                    
                  </div>  
				  <div class="chart tab-pane pre-scrollablemarco d-none" id="div_calib_eq" style="position: relative;">			
                   
                  </div> 
				 <div class="chart tab-pane pre-scrollablemarco d-none" id="div_calib_fact" style="position: relative;">			
                    
                  </div>  				  
				  <div class="chart tab-pane pre-scrollablemarco d-none" id="div_calib_finalcheck" style="position: relative;">			
                    
                  </div>
				  <div class="chart tab-pane pre-scrollablemarco d-none" id="div_scripttime" style="position: relative;">			
                    
                  </div>
				  <div class="chart tab-pane pre-scrollablemarco d-none" id="div_diveditparamciu" style="position: relative;">			
						<!--Inicio modo edicion SO -->
						 <div class="chart tab-pane pre-scrollablemarco  " id="editparampo" style="position: relative; ">
							
							
							<div class="form-group row" >
							<label for="inputPassword" class="col-sm-1 col-form-label">Ciu Model:</label>
							<div class="col-sm-4">
								<span name="txtciushow" id="txtciushow" >  </span>
								<input type="hidden"  id="txtlistcius" name="txtlistcius" value="">
								</div>

							<div class="col-sm-4">
							<input type="hidden" class="form-control" id="lossnamodif" name="lossnamodif" >	
							
<input type="hidden" class="form-control" id="txtsoexternal" name="txtsoexternal"  data-smk-type="number" min="1"  data-validate="true" >	
								
							</div>
						  </div>
						  <div class="container">
						  							<label for="inputPassword" class="col-sm-2 col-form-label">Serial Number:</label>
						  <span class="autocomplete-select-lossn"></span>	
						  
							<br>
						
						  </div>
							<div class="form-group row">
							<label for="inputPassword" class="col-sm-2 col-form-label" >Description:</label>
							<div class="col-sm-4	">
										  <textarea class="form-control" id="txtdescripso" data-validate="false"  name="txtdescripso" rows="4"></textarea>
							</div>
							<label for="inputPassword" class="col-sm-2 col-form-label">Notes PO:</label>
							<div class="col-sm-4">
								  <textarea class="form-control"  id="txtnotepo" name="txtnotepo"  data-validate="false" rows="4"></textarea>
							</div>
							</div>
						 
							<!-- NUEVO RENGLON FORM  -->
							<!-- NUEVO RENGLON FORM  -->
							<div class="form-group row">
							<label for="inputPassword" class="col-sm-2 col-form-label">POWER SUPPLY TYPE:</label>
							<div class="col-sm-2">
										<select  id="txtpwrsupply" name="txtpwrsupply" class="custom-select my-1 mr-sm-2 form-control" data-validate="true">
										
											<option value="">-select-</option>
										<option value="AC/DC">AC/DC</option>
										<option value="DC/DC">DC/DC</option>
								
										</select>
							</div>
							<label for="inputPassword" class="col-sm-1 col-form-label">RC-G for BWA:</label>
							<div class="col-sm-1">
								
								<input type="checkbox"  data-toggle="toggle"  data-off="NO" data-on="YES" id="txtrcgbwa" name="txtrcgbwa" >
								<input type="hidden"  data-toggle="toggle"  data-off="NO" data-on="YES" id="vhtxtrcgbwa" name="vhtxtrcgbwa" value="" >
							</div>
							<label for="inputPassword" class="col-sm-1 col-form-label">Modem for Digital:</label>
							<div class="col-sm-1">
								<input type="checkbox"  data-toggle="toggle" data-on="YES" data-off="NO" id="txtmoden" name="txtmoden">
								<input type="hidden"  data-toggle="toggle"  data-off="NO" data-on="YES" id="vhtxtmoden" name="vhtxtmoden" value="" >
								

							</div>
						  </div>
							<!-- NUEVO RENGLON FORM  -->
							
							  <!-- NUEVO RENGLON FORM  -->
							<div class="form-group row">
							<label for="inputPassword" class="col-sm-2 col-form-label">DL gain (dB)</label>
							<div class="col-sm-4	">
							  <input type="number" class="form-control" id="txtdlgain"  min="1"name="txtdlgain" placeholder="DL GAIN (dB)" data-validate="true">
							</div>
							<label for="inputPassword" class="col-sm-2 col-form-label">UL gain (dB)</label>
							<div class="col-sm-4">
							  <input type="number" class="form-control" id="txtulgain" min="1" name="txtulgain" placeholder="UL GAIN (dB)" data-validate="true">
							</div>
						  </div>
						  
							<!-- NUEVO RENGLON FORM  -->
							  <!-- NUEVO RENGLON FORM  -->
							<div class="form-group row">
							<label for="inputPassword" class="col-sm-2 col-form-label">DL Max Pwr Out (dBm)</label>
							<div class="col-sm-4	">
							  <input type="number" class="form-control" id="txtdlmaxpwr" min="1" name="txtdlmaxpwr" placeholder="DL Max Pwr Out (dBm)" data-validate="true">
							</div>
							<label for="inputPassword" class="col-sm-2 col-form-label">UL Max Pwr Out (dBm)</label>
							<div class="col-sm-4">
							  <input type="number" class="form-control" id="txtulmaxpwr" min="1" name="txtulmaxpwr" placeholder="UL Max Pwr Out (dBm)" data-validate="true">
							</div>
						  </div>
						  
							<!-- NUEVO RENGLON FORM  -->
						  
						 
							<!-- NUEVO RENGLON FORM  -->
							<div class="progress progress-xxs">
									 <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
									 </div>
								</div>
								<br>
							
							
							
								<!-- NUEVO RENGLON FORM  -->
							<div class="form-group row">
						  
							<div class="col-sm-6">
							 <table class="table " >
								
								<tr>
									<td><label  class=" col-form-label">Unit DL (MHz): Start: </label>	<input type="number" class="form-control col-sm-8" id="txtchudstart" min=1 data-validate="false" name="txtchudstart" placeholder="000.000"></td>
									<td><label  class=" col-form-label">  &nbsp; Stop: </label>  <input type="number" class="form-control  col-sm-8" id="txtchudstop" min=1 data-validate="false" name="txtchudstop" placeholder="000.000"> </td>
								</tr>
								<tr>
									<td><label  class=" col-form-label">Unit UL (MHz):	   Start: </label> <input type="number" class="form-control  col-sm-8" id="txtchulstart" min=1 data-validate="false" name="txtchulstart" placeholder="000.000"> </td>
									<td><label  class=" col-form-label">  &nbsp; Stop: </label>  <input type="number" class="form-control  col-sm-8" id="txtchulstop" min=1 data-validate="false" name="txtchulstop" placeholder="000.000">  </td>
								</tr>
								<tr>
									<td> &nbsp; </td>
									<td>
									 <button type="button" class="btn btn-smk btn-outline-primary btn-flat" onclick="add_list_gain()">Add to List</button>
								<input type="hidden" class="form-control" id="templistagainuldl" name="templistagainuldl">
									</td>
								</tr>			
							</table>		
									
								
							
							</div>
							
							<div class="col-sm-6">
								<div class="col-sm-8" id="listagainuldl" name="listagainuldl" > UNIT (DL - UL) List
								<table class="table table-striped table-sm " >
										  <thead>
											<tr>
											  <th style="width: 10px">#</th>
											  <th>DL (Start - Stop) </th>
											  <th>UL (Start - Stop) </th>
											  <th style="width: 40px">Action</th>
											</tr>
										  </thead>
										  <tbody>
										  
									   
										  </tbody>
										</table>
								</div>
							</div>
						  </div>  
						  
									<!-- NUEVO RENGLON FORM  -->
							<div class="form-group row">
						  
							<div class="col-sm-6">
							 <table class="table " >
								
								<tr>
									<td><label  class=" col-form-label">DPX low pass start (MHz): </label>	<input type="number" class="form-control col-sm-8" id="txtdpxlowstart"  min=1 name="txtdpxlowstart" placeholder="000.000"></td>
									<td><label  class=" col-form-label">  &nbsp; Stop (MHz): </label>  <input type="number" class="form-control  col-sm-8" id="txtdpxlowstop" min=1 data-validate="false" name="txtdpxlowstop" placeholder="000.000"> </td>
								</tr>
								<tr>
									<td><label  class=" col-form-label">DPX high pass start (MHz): </label> <input type="number" class="form-control  col-sm-8" id="txtdpxhighstart"  min=1 name="txtdpxhighstart" placeholder="000.000"> </td>
									<td><label  class=" col-form-label">  &nbsp; Stop (MHz): </label>  <input type="number" class="form-control  col-sm-8" id="txtdpxhighstop" min=1 data-validate="false" name="txtdpxhighstop" placeholder="000.000">  </td>
								</tr>
								<tr>
									<td> &nbsp; </td>
									<td>
									 <button type="button" class="btn btn-smk btn-outline-primary btn-flat" onclick="add_list_dpx()">Add to DPX List</button>
								<input type="hidden" class="form-control" id="templistadpx" name="templistadpx">
									</td>
								</tr>			
							</table>		
									
								
							
							</div>
							
							<div class="col-sm-6">
								<div class="col-sm-8" id="listadpx" name="listadpx" > DPX (Low - High) List
								<table class="table table-striped table-sm " >
										  <thead>
											<tr>
											  <th style="width: 10px">#</th>
											  <th>Low (Start - Stop) </th>
											  <th>High (Start - Stop) </th>
											  <th style="width: 40px">Action</th>
											</tr>
										  </thead>
										  <tbody>
										  
									   
										  </tbody>
										</table>
								</div>
							</div>
						  </div>  
							<!-- NUEVO RENGLON FORM  -->
							
								  <!-- NUEVO RENGLON FORM  -->
							<div class="form-group row">
							
							
							<label for="inputPassword" class="col-sm-2 col-form-label">Notes Dpx:</label>
							<div class="col-sm-10">
								  <textarea class="form-control"  id="txtnotedpc" name="txtnotedpc"  data-validate="false" rows="4"></textarea>
							</div>
						  </div>
							
								<div class="progress progress-xxs">
									 <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
									 </div>
								</div>
								<br>
							<!-- NUEVO RENGLON FORM  -->
							<div class="form-group row">
						  
							
							<div class="col-sm-6	">
							   <label  class="col-sm-6 col-form-label">DL Channels (MHz):</label>  <input type="number" class="form-control" data-validate="false" min=1 id="txtchud" name="txtchud" placeholder="000.000">
							  <label  class="col-sm-6 col-form-label">UL Channels (MHz):	</label>    <input type="number" class="form-control" data-validate="false" min=1 id="txtchul" name="txtchul" placeholder="000.000"> 
								<button type="button" class="btn btn-smk btn-outline-primary btn-flat" onclick="add_channels()">Add to Channel List</button>
								<input type="hidden" class="form-control" id="templistchannel" name="templistchannel">
							</div>
							
							<div class="col-sm-6">
								<div class="col-sm-8" id="listachannel" name="listachannel" >
								<table class="table table-striped table-sm " >
										  <thead>
											<tr>
											  <th style="width: 10px">#</th>
											  <th>Channels List</th>
										   
											  <th style="width: 40px">Action</th>
											</tr>
										  </thead>
										  <tbody>
										  
									   
										  </tbody>
										</table>
								</div>
							</div>
						  </div>  
							<!-- NUEVO RENGLON FORM  -->
						
							  <!-- NUEVO RENGLON FORM  -->
							<div class="form-group row">
							
							
							<label for="inputPassword" class="col-sm-2 col-form-label">Notes Channel:</label>
							<div class="col-sm-10">
								  <textarea class="form-control"  id="txtnotechanel" name="txtnotechanel"  data-validate="false" rows="4"></textarea>
							</div>
						  </div>
							
							<br>
							<div class="progress progress-xxs">
									 <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
									 </div>
								</div>
								<br>
							
						  
							 <div class="form-group row">
						  
							<div class="col-sm-4	">
							
							  
							</div>
							
							<?php if ($permiso_create_edit_po =="Y")
									{
																?>
							<div class="col-sm-4">
								<button type="button" class="btn btn-primary btn-block" id="btnchangep" name="btnchangep" onclick="save_new_rev()" >Save New Revision</button>
							</div>
								<?php  } ?>
						  </div>	
						<!--Fin modo edicion SO -->
                  </div>
                </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
					<!-- fin detalle so -->
					
					<p name="detallelog1" id="detallelog1" ></p>						
					<p name="msjwait" id="msjwait" align="center"><img src="img/waitazul.gif" width="100px" ></p>						
                  </div>
              
                  </div><!-- /.card-pane-right -->
                </div><!-- /.d-md-flex -->
              </div>
              <!-- /.card-body -->
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

<script src="crypto-js.js"></script><!-- https://github.com/brix/crypto-js/releases crypto-js.js can be download from here -->

<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="toastr.min.js"></script>

<script src="licencefiplex_mm.js"></script>
<script src="licencefiplex1.js"></script>
<script src="js/jquery.inactivityTimeout.js"></script>
<script src="js/moment-timezone-with-data.js"></script>

<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- DataTables -->
<script src="<?php echo $folderservidor; ?>plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo $folderservidor; ?>plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

<script type="text/javascript" src="js/tabulator.min.js"></script>
 <script src="js/eModal.min.js" type="text/javascript" />

<script src="sweetalert2/sweetalert2.min.js"></script>
<link rel="stylesheet" href="sweetalert2/sweetalert2.min.css">
<script src="js/bootstrap4-toggle.min.js"></script>
<script src="js/bootstrap-typeahead.js"></script>
<script src="js/select2.min.js"></script>


  <link href="css/bootstrap4-toggle.min.css" rel="stylesheet">


<link rel="stylesheet" href="sweetalert2/msweetalert2.min.css">
 <script src="js/bundle.min.js"></script>

</body>

<script type="text/javascript">

   	var cantunitfremostradas = 0;
   
	$( document ).ready(function() {
		
		//Inicio mostrar hora live
		 var interval = setInterval(function() {
			 
        var momentNow = moment();
		var newYork    = momentNow.tz('America/New_York').format('ha z');
        $('#date-part').html(momentNow.format('YYYY/MM/DD') 	  );
        $('#date-part').html(momentNow.format('YYYY/MM/DD') 	  );
        $('#time-part').html(momentNow.format('hh:mm:ss'));
		}, 100);
		//FIN mostrar hora live
		//	console.log( "ready!" );
			$('#msjwaitline ').hide();
			$('#divscrolllog').show(); 
			$('#p-b0').hide();
			$('#p-b0').CardWidget('toggle');		
			$("#detallelog").hide();
			$("#detallelog").text("");
			$("#msjwait").hide();		


				$("#divgeneralinfo").addClass('d-none');
				$("#divgeneralinfoparam").addClass('d-none');
				$("#divdetinfolog").addClass('d-none');
				
				$("#diveq").addClass('d-none');
				$("#divfactory").addClass('d-none');
				$("#divfinalcheck").addClass('d-none');
				$("#divgroupbyciu").addClass('d-none');
				
					$("#divgeneralinfo").removeClass('d-none');
				$("#divgeneralinfoparam").removeClass('d-none');
				$("#divdetinfolog").removeClass('d-none');

				div_y_tabla_ocultas();

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

				$('#closebusqueda').show();
				$('#openbusqueda').hide();
				
				$("#example1").DataTable({
							 "paging": true,
						  "lengthChange": false,
						  "searching": true,
						  "ordering": false,
						  "info": true,
						  "autoWidth": false,
						  "iDisplayLength": 12,
							language: {
								searchPlaceholder: "Search	",
								search: "",
							  },
							  "drawCallback": function( settings ) {
        var api = this.api();
 
        // Output the data for the visible rows to the browser's console
		//console.log('HOla Si' + $("[type=search]" ).val());
		
		if ($("[type=search]" ).val() !="" && $("[type=search]" ).val().length>8)
		{
			  //console.log( api.rows( {page:'current'} ).data() );
			$.each(api.rows( {page:'current'} ).data(), function(index, value){
			//console.log(index + " ----- " + value + '<br>');
				var str = ''+value;
				var res = str.split("###");
			//	console.log("Encontre"+ res[3]+"---"+res[4]);
				//$("#collapse"+ res[3]).collapse('toggle');
				show_ciu_search(res[3], res[4]);
				
				setTimeout(function(){
							if ($('#collapse'+res[3]).is(":hidden") == true)
							{
									$("#collapse"+ res[3]).collapse('toggle');
							}
				 //	console.log("Collapose IdSO:"+ res[3]);
				}, 1000);
				
			
			
			
			});
		}
      
    }
						}
				);				
				
			
	});
	

	// controlar inactividad en la web	
		$(document).inactivityTimeout({
                inactivityWait: 500,
                dialogWait: 100,
                logoutUrl: 'index.php?t=jquerytimeout'
            })
	// fin controlar inactividad en la web		
	
	 /* requesting data */
     		
		
	 	var table = $('#example2').DataTable();
 
	table.on( 'draw', function () { 
	//	console.log( 'Redraw occurred at: '+new Date().getTime() );
		$('.knob').knob({ 	})	
	} );
	
	$(function () {
  			$('.knob').knob({ 
			})

	})
  
	function habilitarbusqueda()
	{		
		$('#openbusqueda').hide();
		$('#closebusqueda').show();
		$("#example1").DataTable({
					 "destroy": true,
						 "paging": true,
					  "lengthChange": false,
					  "searching": true,						  
					  "ordering": false,
					  "info": true,
					  "autoWidth": false,
					  "iDisplayLength": 10
					}
			);
					
					
	}
   
	function dehabilitarbusqueda()
	{

			$('#closebusqueda').hide();
			$('#openbusqueda').show();
			$("#example1").DataTable({
						 "destroy": true,
							 "paging": true,
						  "lengthChange": false,
						  "searching": false,						  
						  "ordering": false,
						  "info": true,
						  "autoWidth": false,
						  "iDisplayLength": 10
						}
				);
		
				
				
	} 
	
	 function show_info_log(vciu,cciu_sn,vso,cuantomuestro)
  {
			$("#msjwait").fadeIn('slow');   
		   var myTable = $('#myTable');
		   $("#myTable").addClass('d-none');
		   $("#myTabledib").addClass('d-none');
		   
		   $("#myTabledibsn").addClass('d-none');
		   $("#myTabledibfw").addClass('d-none');
		   $("#myTabledib").addClass('d-none');
		   $("#myTabledibciu").addClass('d-none');
		   $("#myTablecaliffw").addClass('d-none');
		   $("#myTablecalifsn").addClass('d-none');
		   $("#myTablecalifciu").addClass('d-none');
		   $("#myTablecaliffreq").addClass('d-none');
		   $("#myTabletimescript").addClass('d-none');
		   
		   
		   var nuevo_cuantoamost=0;
		   var msjlabel="";
				if( cuantomuestro ==1)
			    { 
					nuevo_cuantoamost=2;
					msjlabel="View all Rev";
				}
				else
				{
					nuevo_cuantoamost=1;
					msjlabel="See last Rev";
				}
		   //show_CIU_SN_details(idsaleorders, vciu, vciunomdiv,cciu_sn, name_show_customerSO,cuantoamuestro)
		   //show_info_log(vciu,cciu_sn,name_show_customerSO,cuantoamuestro)
		   myTable.html('<h6><a href="#" onclick="show_info_log('+"'"+vciu+"','"+cciu_sn+"','"+vso+"'"+','+nuevo_cuantoamost+')"><span class="badge badge-primary">'+msjlabel+'</span></a></h6><table id="myTable"  class="table table-bordered table-sm texto10 scrolltablemarco"><tr data-row="0" class="table-info" ><td data-row="0" data-col="0"></td></tr><tr data-row="1"><td data-row="1" data-col="0"><b>Approved:</b> </td></tr><tr data-row="2"><td data-row="2" data-col="0"><b>Power Supply:PO:</b> </td> </tr><tr data-row="3"><td data-row="3" data-col="0"><b>PO:</b></td></tr><tr data-row="4"><td data-row="4" data-col="0"><b>RC-G for BWA:</b> </td></tr><tr data-row="5"><td data-row="5" data-col="0"><b>Modem Digital:</b></td></tr><tr data-row="6"><td data-row="6" data-col="0"><b>Descripcion:</b> </td></tr><tr data-row="7"><td data-row="7" data-col="0"><b>Approved by:</b> </td></tr></table> ');
		   
		   var myTablesubband = $("#myTablesubband");
		   myTablesubband.html("<table id='myTablesubband' border='1' class='table table-bordered table-sm texto10 table-striped  scrolltablemarco'><tr data-rowsubband='0' class='table-info'><td data-rowsubband='0' data-colsubband='0'><B>SUB.BAND<B> </td></tr><tr data-rowsubband='1'><td data-rowsubband='1' data-colsubband='0'><b>Start:</b></td></tr><tr data-rowsubband='2'><td data-rowsubband='2' data-colsubband='0'><b>Center:</b></td></tr><tr data-rowsubband='3'><td data-rowsubband='3' data-colsubband='0'><b>Stop:</b></td></tr></table>");
		   
		   var myTablechanel = $("#myTablechanel");
		   myTablechanel.html("<table id='myTablechanel' border='1' class='table table-bordered table-sm texto10 scrolltablemarco'> <tr data-rowchanel='0' class='table-info'><td data-rowchanel='0' data-colchanel='0'><B>FREC. CH.<B></td></tr><tr data-rowchanel='1'><td data-rowchanel='1' data-colchanel='0'><b>FCh[0]:</b></td></tr><tr data-rowchanel='2'><td data-rowchanel='2' data-colchanel='0'><b>FCh[1]:</b></td></tr><tr data-rowchanel='3'><td data-rowchanel='3' data-colchanel='0'><b>FCh[2]:</b></td></tr><tr data-rowchanel='4'><td data-rowchanel='4' data-colchanel='0'><b>FCh[3]:</b></td></tr>							<tr data-rowchanel='5'><td data-rowchanel='5' data-colchanel='0'><b>FCh[4]:</b></td></tr>							<tr data-rowchanel='6'><td data-rowchanel='6' data-colchanel='0'><b>FCh[5]:</b></td></tr>							<tr data-rowchanel='7'><td data-rowchanel='7' data-colchanel='0'><b>FCh[6]:</b></td></tr>							<tr data-rowchanel='8'><td data-rowchanel='8' data-colchanel='0'><b>FCh[7]:</b></td></tr>							<tr data-rowchanel='9'><td data-rowchanel='9' data-colchanel='0'><b>FCh[8]:</b></td></tr>							<tr data-rowchanel='10'><td data-rowchanel='10' data-colchanel='0'><b>FCh[9]:</b></td></tr>	<tr data-rowchanel='11'><td data-rowchanel='11' data-colchanel='0'><b>FCh[11]:</b></td></tr><tr data-rowchanel='12'><td data-rowchanel='12' data-colchanel='0'><b>FCh[12]:</b></td></tr><tr data-rowchanel='13'><td data-rowchanel='13' data-colchanel='0'><b>FCh[13]:</b></td></tr>							<tr data-rowchanel='14'><td data-rowchanel='14' data-colchanel='0'><b>FCh[14]:</b></td></tr><tr data-rowchanel='15'><td data-rowchanel='15' data-colchanel='0'><b>FCh[15]:</b></td></tr><tr data-rowchanel='16'><td data-rowchanel='16' data-colchanel='0'><b>FCh[16]:</b></td></tr><tr data-rowchanel='17'><td data-rowchanel='17' data-colchanel='0'><b>FCh[17]:</b></td></tr> 							<tr data-rowchanel='18'><td data-rowchanel='18' data-colchanel='0'><b>FCh[18]:</b></td></tr><tr data-rowchanel='19'><td data-rowchanel='19' data-colchanel='0'><b>FCh[19]:</b></td></tr><tr data-rowchanel='20'><td data-rowchanel='20' data-colchanel='0'><b>FCh[20]:</b></td></tr><tr data-rowchanel='21'><td data-rowchanel='21' data-colchanel='0'><b>FCh[21]:</b></td></tr><tr data-rowchanel='22'><td data-rowchanel='22' data-colchanel='0'><b>FCh[22]:</b></td></tr><tr data-rowchanel='23'><td data-rowchanel='23' data-colchanel='0'><b>FCh[23]:</b></td></tr><tr data-rowchanel='24'><td data-rowchanel='24' data-colchanel='0'><b>FCh[24]:</b></td></tr><tr data-rowchanel='25'><td data-rowchanel='25' data-colchanel='0'><b>FCh[25]:</b></td></tr>							<tr data-rowchanel='26'><td data-rowchanel='26' data-colchanel='0'><b>FCh[26]:</b></td></tr><tr data-rowchanel='27'><td data-rowchanel='27' data-colchanel='0'><b>FCh[27]:</b></td></tr><tr data-rowchanel='28'><td data-rowchanel='28' data-colchanel='0'><b>FCh[28]:</b></td></tr><tr data-rowchanel='29'><td data-rowchanel='29' data-colchanel='0'><b>FCh[29]:</b></td></tr><tr data-rowchanel='30'><td data-rowchanel='30' data-colchanel='0'><b>FCh[30]:</b></td></tr>");
		   var myTableul = $('#myTableul');
		   myTableul.html('<h6><a href="#" onclick="show_info_log('+"'"+vciu+"','"+cciu_sn+"','"+vso+"'"+','+nuevo_cuantoamost+')"><span class="badge badge-primary">'+msjlabel+'</span></a></h6>'+"<table id='myTableul' border='1' class='table table-bordered table-sm texto10 scrolltablemarco'><tr data-rowul='0'  class='table-info' ><td data-rowul='0' data-colul='0'><B>PARAMETERS<B></td></tr><tr data-rowul='1'><td data-rowul='1' data-colul='0'><b>Gain:</b></td></tr><tr data-rowul='2'><td data-rowul='2' data-colul='0'><b>Max Pwr:</b></td></tr><tr data-rowul='3'><td data-rowul='3' data-colul='0'><b>Freq Start:</b></td></tr><tr data-rowul='4'><td data-rowul='4' data-colul='0'><b>Freq Stop:</b> </td></tr></table>");
			$.ajax
			({ 
				url: 'ajax_show_info_sn.php',
				data: "idciu="+vciu+'&ciusn='+cciu_sn+"&cuantomuestro="+cuantomuestro,	
				type: 'post',	
				async:true,
                cache:false,				
				datatype:'JSON',
				success: function(data)
				{
					//detallelog
					console.log('TT:'+data.uldl);
					
						$.each(data.gi, function(i, item) {
						//	console.log('muestro:'+item);
							AddNewCol(1,item);
						});
						/// Los chanes
						var loschannel = 0;
						var arramch = [];		
						$.each(data.ch, function(ich, itemch) {			
								
								var arramch = [];							
								arramch.push( json2array(itemch));
							
									//console.log('d1:'+arramch[0][1]+'-d0:'+arramch[0][0]+'-d2:'+arramch[0][2]+'-d3:'+arramch[0][3]+'-d4:'+arramch[0][4]);
								AddNewColchanel(1,itemch,'chanel');
								//AddNewRowchanel	 (1,itemch,'chanel');	
								$("#myTablechanel").removeClass('d-none');								
														
						});
						
						$.each(data.uldl, function(iud, itemud) {
							console.log('muestro:'+itemud);
							AddNewColdl(1,itemud,'ul');
							$("#myTableul").removeClass('d-none');
						
							
							
						});
						
						//myTableUnit_DelRow
						
						$.each(data.uldlsubband, function(isubband, itemsubband) {
							
							AddNewColdl(1,itemsubband,'subband');
							$("#myTablesubband").removeClass('d-none');
						});
						var losbuttons="";
						$.each(data.lg, function(ilg, itemlg) {
							//console.log('Log:'+itemlg);
							var arram = [];
							
							arram.push( json2array(itemlg));
						//	console.log('array:'+arram[0][1]+'-band'+arram[0][0]+'-runinfoid'+arram[0][2]);
							if (arram[0][0]==0)
							{
								losbuttons = losbuttons + '<a href="#"  onclick="show_log('+arram[0][2]+')"><span class="badge badge-primary" ><i class="fas fa-search"></i> Rev '+arram[0][1]+'</span></a> - ';
							}
							else
							{
								losbuttons = losbuttons + '<span class="badge badge-primary" onclick="show_log('+arram[0][2]+')"><i class="fas fa-search"></i> Band:'+arram[0][0]+' - Rev '+arram[0][1]+'</span> - ';	
							}
							
						});
						
						losbuttons = losbuttons + '<textarea class="form-control" rows="18" id="detallelog" name="detallelog"></textarea>';
						$('#infolog').html(losbuttons); 
					$("#msjwait").hide();	
					$("#myTable").removeClass('d-none');
					
					
				
					$("#infolog").removeClass('d-none');
					
					$("#msjwait").hide();	
					$("#myTable").removeClass('d-none');
					
					
					
					
														
					
					$("#myTabledibfw").addClass('d-none');
					$("#myTabledibciu").addClass('d-none');
					$("#myTablecaliffw").addClass('d-none');
					
					$("#myTablecalifsn").addClass('d-none');
					$("#myTablecalifciu").addClass('d-none');
					$("#myTablecaliffreq").addClass('d-none');
					
					
					//mostramos datos del SN y CIU selecionado.
				    $('#ciusnshow').html(' &nbsp; '+vso+' <b>/</b> '+vciu +' <b>/</b> '+ cciu_sn); 
					$('#ciusnshowbks').html(' &nbsp; '+vso+' <b>/</b> '+vciu +' <b>/</b> '+ cciu_sn); 
					

					
							
				}
			});
  }
  
   function show_info_log2020(vciu,cciu_sn,vso,cuantomuestro, vidorders)
  {
			$("#msjwait").fadeIn('slow');   
		   var myTable = $('#myTable');
		   $("#myTable").addClass('d-none');
		   $("#myTabledib").addClass('d-none');
		   
		   $("#myTabledibsn").addClass('d-none');
		   $("#myTabledibfw").addClass('d-none');
		   $("#myTabledib").addClass('d-none');
		   $("#myTabledibciu").addClass('d-none');
		   $("#myTablecaliffw").addClass('d-none');
		   $("#myTablecalifsn").addClass('d-none');
		   $("#myTablecalifciu").addClass('d-none');
		   $("#myTablecaliffreq").addClass('d-none');
		   $("#myTabletimescript").addClass('d-none');
		   
		   
		   var nuevo_cuantoamost=0;
		   var msjlabel="";
				if( cuantomuestro ==1)
			    { 
					nuevo_cuantoamost=2;
					msjlabel="View all Rev";
				}
				else
				{
					nuevo_cuantoamost=1;
					msjlabel="See last Rev";
				}
		   //show_CIU_SN_details(idsaleorders, vciu, vciunomdiv,cciu_sn, name_show_customerSO,cuantoamuestro)
		   //show_info_log(vciu,cciu_sn,name_show_customerSO,cuantoamuestro)
		   myTable.html('<h6><a href="#" onclick="show_info_log2020('+"'"+vciu+"','"+cciu_sn+"','"+vso+"'"+','+nuevo_cuantoamost+','+vidorders+')"><span class="badge badge-primary">'+msjlabel+'</span></a></h6><table id="myTable"  class="table table-bordered table-sm texto10 scrolltablemarco"><tr data-row="0" class="table-info" ><td data-row="0" data-col="0"></td></tr><tr data-row="1"><td data-row="1" data-col="0"><b>Approved:</b> </td></tr><tr data-row="2"><td data-row="2" data-col="0"><b>Power Supply:PO:</b> </td> </tr><tr data-row="3"><td data-row="3" data-col="0"><b>PO:</b></td></tr><tr data-row="4"><td data-row="4" data-col="0"><b>RC-G for BWA:</b> </td></tr><tr data-row="5"><td data-row="5" data-col="0"><b>Modem Digital:</b></td></tr><tr data-row="6"><td data-row="6" data-col="0"><b>Descripcion:</b> </td></tr><tr data-row="7"><td data-row="7" data-col="0"><b>Approved by:</b> </td></tr></table> ');
		   
		   var myTablesubband = $("#myTablesubband");
		   myTablesubband.html("<table id='myTablesubband' border='1' class='table table-bordered table-sm texto10 table-striped  scrolltablemarco'><tr data-rowsubband='0' class='table-info'><td data-rowsubband='0' data-colsubband='0'><B>DPX<B> </td></tr><tr data-rowsubband='1'><td data-rowsubband='1' data-colsubband='0'><b>Freq[0] Start/Stop:</b></td></tr><tr data-rowsubband='2'><td data-rowsubband='2' data-colsubband='0'><b>Freq[1] Start/Stop:</b></td></tr><tr data-rowsubband='3'><td data-rowsubband='3' data-colsubband='0'><b>Freq[2] Start/Stop:</b></td></tr><tr data-rowsubband='4'><td data-rowsubband='4' data-colsubband='0'><b>Freq[3] Start/Stop:</b></td></tr><tr data-rowsubband='5'><td data-rowsubband='5' data-colsubband='0'><b>Freq[4] Start/Stop:</b></td></tr><tr data-rowsubband='6'><td data-rowsubband='6' data-colsubband='0'><b>Freq[5] Start/Stop:</b></td></tr><tr data-rowsubband='7'><td data-rowsubband='7' data-colsubband='0'><b>Freq[6] Start/Stop:</b></td></tr><tr data-rowsubband='8'><td data-rowsubband='8' data-colsubband='0'><b>Freq[7] Start/Stop:</b></td></tr><tr data-rowsubband='9'><td data-rowsubband='9' data-colsubband='0'><b>Freq[8] Start/Stop:</b></td></tr><tr data-rowsubband='10'><td data-rowsubband='10' data-colsubband='0'><b>Freq[9] Start/Stop:</b></td></tr><tr data-rowsubband='11'><td data-rowsubband='11' data-colsubband='0'><b>Freq[10] Start/Stop:</b></td></tr></table>");
		   
		   var myTablechanel = $("#myTablechanel");
		   myTablechanel.html("<table id='myTablechanel' border='1' class='table table-bordered table-sm texto10 scrolltablemarco'> <tr data-rowchanel='0' class='table-info'><td data-rowchanel='0' data-colchanel='0'><B>FREC. CH.<B></td></tr><tr data-rowchanel='1'><td data-rowchanel='1' data-colchanel='0'><b>FCh[0]:</b></td></tr><tr data-rowchanel='2'><td data-rowchanel='2' data-colchanel='0'><b>FCh[1]:</b></td></tr><tr data-rowchanel='3'><td data-rowchanel='3' data-colchanel='0'><b>FCh[2]:</b></td></tr><tr data-rowchanel='4'><td data-rowchanel='4' data-colchanel='0'><b>FCh[3]:</b></td></tr>							<tr data-rowchanel='5'><td data-rowchanel='5' data-colchanel='0'><b>FCh[4]:</b></td></tr>							<tr data-rowchanel='6'><td data-rowchanel='6' data-colchanel='0'><b>FCh[5]:</b></td></tr>							<tr data-rowchanel='7'><td data-rowchanel='7' data-colchanel='0'><b>FCh[6]:</b></td></tr>							<tr data-rowchanel='8'><td data-rowchanel='8' data-colchanel='0'><b>FCh[7]:</b></td></tr>							<tr data-rowchanel='9'><td data-rowchanel='9' data-colchanel='0'><b>FCh[8]:</b></td></tr>							<tr data-rowchanel='10'><td data-rowchanel='10' data-colchanel='0'><b>FCh[9]:</b></td></tr>	<tr data-rowchanel='11'><td data-rowchanel='11' data-colchanel='0'><b>FCh[11]:</b></td></tr><tr data-rowchanel='12'><td data-rowchanel='12' data-colchanel='0'><b>FCh[12]:</b></td></tr><tr data-rowchanel='13'><td data-rowchanel='13' data-colchanel='0'><b>FCh[13]:</b></td></tr>							<tr data-rowchanel='14'><td data-rowchanel='14' data-colchanel='0'><b>FCh[14]:</b></td></tr><tr data-rowchanel='15'><td data-rowchanel='15' data-colchanel='0'><b>FCh[15]:</b></td></tr><tr data-rowchanel='16'><td data-rowchanel='16' data-colchanel='0'><b>FCh[16]:</b></td></tr><tr data-rowchanel='17'><td data-rowchanel='17' data-colchanel='0'><b>FCh[17]:</b></td></tr> 							<tr data-rowchanel='18'><td data-rowchanel='18' data-colchanel='0'><b>FCh[18]:</b></td></tr><tr data-rowchanel='19'><td data-rowchanel='19' data-colchanel='0'><b>FCh[19]:</b></td></tr><tr data-rowchanel='20'><td data-rowchanel='20' data-colchanel='0'><b>FCh[20]:</b></td></tr><tr data-rowchanel='21'><td data-rowchanel='21' data-colchanel='0'><b>FCh[21]:</b></td></tr><tr data-rowchanel='22'><td data-rowchanel='22' data-colchanel='0'><b>FCh[22]:</b></td></tr><tr data-rowchanel='23'><td data-rowchanel='23' data-colchanel='0'><b>FCh[23]:</b></td></tr><tr data-rowchanel='24'><td data-rowchanel='24' data-colchanel='0'><b>FCh[24]:</b></td></tr><tr data-rowchanel='25'><td data-rowchanel='25' data-colchanel='0'><b>FCh[25]:</b></td></tr>							<tr data-rowchanel='26'><td data-rowchanel='26' data-colchanel='0'><b>FCh[26]:</b></td></tr><tr data-rowchanel='27'><td data-rowchanel='27' data-colchanel='0'><b>FCh[27]:</b></td></tr><tr data-rowchanel='28'><td data-rowchanel='28' data-colchanel='0'><b>FCh[28]:</b></td></tr><tr data-rowchanel='29'><td data-rowchanel='29' data-colchanel='0'><b>FCh[29]:</b></td></tr><tr data-rowchanel='30'><td data-rowchanel='30' data-colchanel='0'><b>FCh[30]:</b></td></tr>");
		   var myTableul = $('#myTableul');
		   myTableul.html('<h6><a href="#" onclick="show_info_log2020('+"'"+vciu+"','"+cciu_sn+"','"+vso+"'"+','+nuevo_cuantoamost+','+vidorders+')"><span class="badge badge-primary">'+msjlabel+'</span></a></h6>'+"<table id='myTableul' border='1' class='table table-bordered table-sm texto10 scrolltablemarco'><tr data-rowul='0'  class='table-info' ><td data-rowul='0' data-colul='0'><B>PARAMETERS<B></td></tr><tr data-rowul='1'><td data-rowul='1' data-colul='0'><b>Gain:</b></td></tr><tr data-rowul='2'><td data-rowul='2' data-colul='0'><b>Max Pwr:</b></td></tr><tr data-rowul='3'><td data-rowul='3' data-colul='0'><b>Freq[0]  Start/Stop:</b></td></tr><tr data-rowul='4'><td data-rowul='4' data-colul='0'><b>Freq[1]  Start/Stop:</b> </td></tr><tr data-rowul='5'><td data-rowul='5' data-colul='0'><b>Freq[2]  Start/Stop:</b> </td></tr><tr data-rowul='6'><td data-rowul='6' data-colul='0'><b>Freq[3]  Start/Stop:</b> </td></tr><tr data-rowul='7'><td data-rowul='7' data-colul='0'><b>Freq[4]  Start/Stop:</b> </td></tr><tr data-rowul='8'><td data-rowul='8' data-colul='0'><b>Freq[5]  Start/Stop:</b> </td></tr><tr data-rowul='9'><td data-rowul='9' data-colul='0'><b>Freq[6]  Start/Stop:</b> </td></tr><tr data-rowul='10'><td data-rowul='10' data-colul='0'><b>Freq[7]  Start/Stop:</b> </td></tr></table>");
			$.ajax
			({ 
				url: 'ajax_show_info_sn_version2.php',
				data: "idciu="+vciu+'&ciusn='+cciu_sn+"&cuantomuestro="+cuantomuestro+"&idord="+vidorders,	
				type: 'post',	
				async:true,
                cache:false,				
				datatype:'JSON',
				success: function(data)
				{
					//detallelog
					console.log(data.uldl);
					
						$.each(data.gi, function(i, item) {
						//	console.log('muestro:'+item);
							AddNewCol(1,item);
						});
						/// Los chanes
						var loschannel = 0;
						var arramch = [];		
						$.each(data.ch, function(ich, itemch) {			
								
								var arramch = [];							
								arramch.push( json2array(itemch));
							
									
								AddNewColchanel(1,itemch,'chanel');
								
								$("#myTablechanel").removeClass('d-none');								
														
						});
					cantunitfremostradas =0;
					var cantjsonreg = 0;
						$.each(data.uldl, function(iud, itemud) {
						console.log('muestro:'+itemud);
							cantjsonreg = cantjsonreg + 1
							AddNewColdl(1,itemud,'ul');
							$("#myTableul").removeClass('d-none');
							
						});
						  var rowCount = $("#myTableul tr").length;
					 var filacargadas =0;
					 filacargadas = cantunitfremostradas / cantjsonreg;
					//	console.log('hola cant' + cantunitfremostradas);
						for (var im = filacargadas; im < 11; im++) 
						{
							//alert('errroacamarco');
						//acamarco	myTableUnit_DelRow(im);
						}	
						
						cantunitfremostradas =0;
						cantjsonreg = 0;
						$.each(data.uldlsubband, function(isubband, itemsubband) {
							cantjsonreg = cantjsonreg + 1
							AddNewColdl(1,itemsubband,'subband');
							$("#myTablesubband").removeClass('d-none');
						});
						//	console.log('hola dpx cant' + cantunitfremostradas+ '----' +cantjsonreg);
						filacargadas =0;
						filacargadas = cantunitfremostradas / cantjsonreg;
						for (var im = 1; im < 12; im++) 
						{
							    var eldato = $('td[data-rowsubband=' + parseInt(im) + ']').text();
								var res = eldato.split(":");
							//	console.log('eldatos split:'+ res[1] +'//'+ res[1].length);
							if ( res[1].length == 2)
							{
								myTabledpx_DelRow(im);	
								
								
							}
							
						}	
						
						var losbuttons="";
						$.each(data.lg, function(ilg, itemlg) {
							//console.log('Log:'+itemlg);
							var arram = [];
							
							arram.push( json2array(itemlg));
						//	console.log('array:'+arram[0][1]+'-band'+arram[0][0]+'-runinfoid'+arram[0][2]);
							if (arram[0][0]==0)
							{
								losbuttons = losbuttons + '<a href="#"  onclick="show_log('+arram[0][2]+')"><span class="badge badge-primary" ><i class="fas fa-search"></i> Rev '+arram[0][1]+'</span></a> - ';
							}
							else
							{
								losbuttons = losbuttons + '<span class="badge badge-primary" onclick="show_log('+arram[0][2]+')"><i class="fas fa-search"></i> Band:'+arram[0][0]+' - Rev '+arram[0][1]+'</span> - ';	
							}
							
						});
						
						losbuttons = losbuttons + '<textarea class="form-control" rows="18" id="detallelog" name="detallelog"></textarea>';
						$('#infolog').html(losbuttons); 
					$("#msjwait").hide();	
					$("#myTable").removeClass('d-none');
					
					
				
					$("#infolog").removeClass('d-none');
					
					$("#msjwait").hide();	
					$("#myTable").removeClass('d-none');
					
					
					
					
														
					
					$("#myTabledibfw").addClass('d-none');
					$("#myTabledibciu").addClass('d-none');
					$("#myTablecaliffw").addClass('d-none');
					
					$("#myTablecalifsn").addClass('d-none');
					$("#myTablecalifciu").addClass('d-none');
					$("#myTablecaliffreq").addClass('d-none');
					
					
					//mostramos datos del SN y CIU selecionado.
				    $('#ciusnshow').html(' &nbsp; '+vso+' <b>/</b> '+vciu +' <b>/</b> '+ cciu_sn); 
					$('#ciusnshowbks').html(' &nbsp; '+vso+' <b>/</b> '+vciu +' <b>/</b> '+ cciu_sn); 
					

					
							
				}
			});
  }
  
   
   function show_log(idlog_view)
   {
	 	   
	 $("#detallelog").fadeOut('fast');  
	  $("#msjwait").fadeIn('slow');   
		
		 $("#uso").val(1);
		 
	    $.ajax
			({ 
				url: 'readlogbyruninfo.php',
				data: "idlog="+idlog_view,	
				type: 'post',
				async:true,
                cache:false,
				success: function(data)
				{
					var datax = JSON.parse(data)
				//	console.log(datax);
                 //   console.log(datax.vuser);
					
					//detallelog
					 $("#msjwait").hide();
					 	$("#detallelog").fadeIn(100);						
						//var re = /<TERM>/g; 						
						$("#detallelog").html(datax.data.replace(/<br>/g,' \r\n'));
						
						if ($( window ).height()>800)
						{
							$("#detallelog").height(585);
						}
						
						
						$( window ).height();
						
						$('#lblvuser').text(datax.vuser.replace("#"," "));
						$('#lblvdevice').text(datax.vdecice.replace("#"," "));
						var anex = "'"+idlog_view+"'" ;
						
						$('#lblvstationr').html(datax.vstation.replace("#"," ") +' <a href="#" onclick="show_log2('+anex	+')") ><i class="fas fa-bug" style="color:blue"></i></a>');
					
				}
			});
   }
     function show_log2(idlog_view)
   {
	 	   
	 	 	   
	 $("#detallelog").fadeOut('fast');  
	  $("#msjwait").fadeIn('slow');   
		
		 $("#uso").val(1);
		 
	    $.ajax
			({ 
				url: 'readlogbyruninfodebug.php',
				data: "idlog="+idlog_view,	
				type: 'post',
				async:true,
                cache:false,
				success: function(data)
				{
					var datax = JSON.parse(data)
				//	console.log(datax);
                 //   console.log(datax.vuser);
					
					//detallelog
					 $("#msjwait").hide();
					 	$("#detallelog").fadeIn(100);						
						//var re = /<TERM>/g; 						
						$("#detallelog").html(datax.data.replace(/<br>/g,' \r\n'));
						$('#lblvuser').text(datax.vuser.replace("#"," "));
						$('#lblvdevice').text(datax.vdecice.replace("#"," "));
						var anex = "'"+idlog_view+"'" ;
						
						$('#lblvstationr').html(datax.vstation.replace("#"," ") +' <a href="#" onclick="show_log('+anex	+')") ><i class="fas fa-bug" style="color:green"></i></a>');
					
				}
			});
			
   }
   
   
   
      function show_ciu_version2020(idsaleorders, nameSO_Customers)
   {
	   var lbl_color ="";
	  
		//alert('hi' + $('#collapse'+idsaleorders).is(":hidden"));
		if ($('#collapse'+idsaleorders).is(":hidden") == true)
		{
		
			$('#collapse'+idsaleorders).html("<p name='msjwaitparticular' id='msjwaitparticular' align='center'><img src='img/waitazul.gif' width='100px' ></p>");
			//	console.log(idsaleorders);
				toastr.options = {
				  "closeButton": false,
				  "debug": false,
				  "newestOnTop": false,
				  "progressBar": true,
				  "positionClass": "toast-bottom-right",
				  "preventDuplicates": false,
				  "onclick": null,
				  "showDuration": "600",
				  "hideDuration": "600",
				  "timeOut": "600",
				  "extendedTimeOut": "600",
				  "showEasing": "swing",
				  "hideEasing": "linear",
				  "showMethod": "fadeIn",
				  "hideMethod": "fadeOut"
				};	
				toastr["success"]("Wait....Search Results", "Attention :: Sales Orders ");
				$.ajax
				({ 
					url: 'ajax_show_CIU_version2.php',
					data: "idsaleorders="+idsaleorders,	
					type: 'post',				
					datatype:'JSON',
				
					success: function(data)
					{
						 $("#msjwait").hide();	
						// console.log("devolvio"+ idsaleorders+ data);
						  var eTable="<div class='card-headermarco'>";					
						  for(var i=0; i<data.length;i++)
						  {
							
							lbl_color ="bg-red";
							  if (data[i].cantdib >=1 )
							  {
								  	lbl_color ="bg-warning";
							  }
							   if (data[i].cantcalib >=1 )
							  {
								  	lbl_color ="bg-info";
							  }
							   if (data[i].cantfinalchk >=1 )
							  {
								  	lbl_color ="bg-green";
							  }
							  
							
												  
						  
							
							
							// eTable += "<a data-toggle='collapse' data-parent='#accordion' onclick="+"show_CIU_SN2020("+idsaleorders+",'"+data[i].ciu+"','"+idsaleorders+data[i].ciu_sincara+"','') href='#collapse"+idsaleorders+data[i].ciu_sincara+"' aria-expanded='true'><img src='img/dh7Sisometric50pxx50px.png' width='40px' > "+data[i].ciu+"&nbsp;<span data-toggle='tooltip' class='badge "+ lbl_color +" mb-2 labelsom'> &nbsp;[ &nbsp;"+data[i].cant_sn+" SN &nbsp;] &nbsp; </span></a>&nbsp;  	-- <a href='#' onclick='show_po_So_Edit("+idsaleorders+",0,0)'><i class='far fa-edit' ></i></a>	<br><div id='collapse"+idsaleorders+data[i].ciu_sincara+"' name id='collapse"+idsaleorders+data[i].ciu_sincara+"' class='panel-collapse in collapse'> ... </div>";
							if ($("#permiso_print_label_flex").val() =='Y')
							{
								eTable += "<a data-toggle='collapse' data-parent='#accordion' onclick="+"show_CIU_SN2020("+idsaleorders+",'"+data[i].ciu+"','"+idsaleorders+data[i].ciu_sincara+"','') href='#collapse"+idsaleorders+data[i].ciu_sincara+"' aria-expanded='true'><img src='img/dh7Sisometric50pxx50px.png' width='40px' > "+data[i].ciu+"&nbsp;<span data-toggle='tooltip' class='badge "+ lbl_color +" mb-2 labelsom'> &nbsp;[ &nbsp;"+data[i].cant_sn+" SN &nbsp;] &nbsp; </span></a>&nbsp;";
								
								eTable +=' &nbsp;&nbsp;<a href="#" onclick="Call_printlabel_todos('+String.fromCharCode(39)+data[i].ciu+String.fromCharCode(39)+','+idsaleorders+')">&nbsp;<i class="fas fa-tasks"></i>&nbsp;<i class="fas fa-print"></i></a>';
								eTable += "<br><div id='collapse"+idsaleorders+data[i].ciu_sincara+"' name id='collapse"+idsaleorders+data[i].ciu_sincara+"' class='panel-collapse in collapse'> ... </div>";
							}
							else
							{
							eTable += "<a data-toggle='collapse' data-parent='#accordion' onclick="+"show_CIU_SN2020("+idsaleorders+",'"+data[i].ciu+"','"+idsaleorders+data[i].ciu_sincara+"','') href='#collapse"+idsaleorders+data[i].ciu_sincara+"' aria-expanded='true'><img src='img/dh7Sisometric50pxx50px.png' width='40px' > "+data[i].ciu+"&nbsp;<span data-toggle='tooltip' class='badge "+ lbl_color +" mb-2 labelsom'> &nbsp;[ &nbsp;"+data[i].cant_sn+" SN &nbsp;] &nbsp; </span></a>&nbsp;  <br><div id='collapse"+idsaleorders+data[i].ciu_sincara+"' name id='collapse"+idsaleorders+data[i].ciu_sincara+"' class='panel-collapse in collapse'> ... </div>";	
							}
							//eTable += "<a data-toggle='collapse' data-parent='#accordion' onclick="+"show_CIU_SN2020("+idsaleorders+",'"+data[i].ciu+"','"+idsaleorders+data[i].ciu_sincara+"','') href='#collapse"+idsaleorders+data[i].ciu_sincara+"' aria-expanded='true'><img src='img/dh7Sisometric50pxx50px.png' width='40px' > "+data[i].ciu+"&nbsp;<span data-toggle='tooltip' class='badge "+ lbl_color +" mb-2 labelsom'> &nbsp;[ &nbsp;"+data[i].cant_sn+" SN &nbsp;] &nbsp; </span></a>&nbsp;  <br><div id='collapse"+idsaleorders+data[i].ciu_sincara+"' name id='collapse"+idsaleorders+data[i].ciu_sincara+"' class='panel-collapse in collapse'> ... </div>";
							
																			
						  }
						  eTable +="</div>";
						  $('#collapse'+idsaleorders).html(eTable);
					}
					/* error: function (xhr, ajaxOptions, thrownError) {
						console.log(xhr.status);
						console.log(thrownError);
						$('#collapse'+idsaleorders).html("<p name='msjwaitparticular' id='msjwaitparticular' align='center'>Error by Ajax Conector</p>");
					  }*/
				});
			}	
   }
   
   function show_CIU_SN2020(idsaleorders, vciu, vciunomdiv,name_show_customerSO,cuantasrev)
   {
	    var ifdualband="";
	   if ($('#collapse'+vciunomdiv).is(":hidden") == true)
		{

 
		//	console.log(idsaleorders);
			toastr.options = {
			  "closeButton": false,
			  "debug": false,
			  "newestOnTop": false,
			  "progressBar": true,
			  "positionClass": "toast-bottom-right",
			  "preventDuplicates": false,
			  "onclick": null,
			  "showDuration": "600",
			  "hideDuration": "600",
			  "timeOut": "600",
			  "extendedTimeOut": "600",
			  "showEasing": "swing",
			  "hideEasing": "linear",
			  "showMethod": "fadeIn",
			  "hideMethod": "fadeOut"
			};	
			toastr["success"]("Wait....Search Results", "Attention :: State of Sale Orders ");
	   
			$.ajax
			({ 
				url: 'ajax_show_CIU_SN_version2.php',
				data: "idsaleorders="+idsaleorders+"&vciu="+vciu+"&qs="+cuantasrev,	
				type: 'post',				
				datatype:'JSON',
				success: function(data)
				{
				//	alert(data);
					
					//detallelog
					 $("#msjwait").hide();				 
					
					  var eTable="<div class='container'><table class='table  table-bordered table-striped table-sm'><tbody>";
					  var det_modules="";
					  var detband = "0";
					
					  for(var i=0; i<data.length;i++)
					  {
						
						
						//<span data-toggle='tooltip'  class='float-right'> &nbsp; <span data-toggle='tooltip' title='1 Calibration' class='badge bg-warning'>Dig. Mod</span>&nbsp;
						//<span data-toggle='tooltip' title='3 Calibration' class='badge bg-primary'>Calib [3]</span>&nbsp;
						//<span data-toggle='tooltip' title='3 Calibration' class='badge bg-success'>Acept [1] </span>
						//eTable= eTable+"<span data-toggle='tooltip' title='3 Calibration' class='badge bg-danger'>Final Chk MARCO</span></span> <div id='collapse"+idsaleorders+vciu+data[i].sn+"' name id='collapse"+idsaleorders+vciu+data[i].sn+"' class='panel-collapse in collapse'> ... </div>";
						if (data[i].ifdualband ==1)
						{
							ifdualband="";
								detband="";
						}
						else
						{
							if (data[i].idband==0)
							{
								ifdualband = "&nbsp;<i class='fas fa-grip-lines-vertical'></i> Band: 700 " ;
								var detband = " [Band:700]";
							}
							if (data[i].idband==1)							
							{
								var detband = "[Band:800]";
							ifdualband = "&nbsp;<i class='fas fa-grip-lines-vertical'></i> Band: 800 " ;	
							}
							
						
						}
						eTable += "<tr >";
						eTable += "<td> <a data-toggle='collapse' data-parent='#accordion' onclick="+"show_CIU_SN_details2020("+idsaleorders+",'"+vciu+"','"+idsaleorders+vciu+data[i].sn+data[i].idband+"','"+data[i].sn+"','"+name_show_customerSO+"',1) href='#collapse"+idsaleorders+vciu+data[i].sn+data[i].idband+"' aria-expanded='true'><i class='nav-icon fas fa-th'></i> "+data[i].sn+ifdualband+"</a>&nbsp&nbsp&nbsp"; 
						
						//eTable +='<a href="#" onclick="Call_create_RMA('+String.fromCharCode(39)+vciu+String.fromCharCode(39)+','+String.fromCharCode(39)+data[i].sn+String.fromCharCode(39)+','+idsaleorders+')" title="Create RMA?"> <i class="nav-icon fas fa-box-open"></i></a> -- <a href="#" onclick="show_po_So_Edit('+idsaleorders+',0,'+"'"+data[i].sn+"'"+')"><i class="far fa-edit" ></i></a>';	
						eTable +='<a href="#" onclick="Call_create_RMA('+String.fromCharCode(39)+vciu+String.fromCharCode(39)+','+String.fromCharCode(39)+data[i].sn+String.fromCharCode(39)+','+idsaleorders+')" title="Create RMA?"> <i class="nav-icon fas fa-box-open"></i></a> ';	
						eTable +='&nbsp&nbsp&nbsp<a href="#" onclick="Call_calibration('+String.fromCharCode(39)+vciu+String.fromCharCode(39)+','+String.fromCharCode(39)+data[i].sn+String.fromCharCode(39)+','+idsaleorders+')" title="View Final Check"> <i class="far fa-eye"></i></i></a>';
						
						if ($("#permiso_print_label_flex").val()=="Y")
						{
						eTable +='<a href="#" onclick="Call_printlabel('+String.fromCharCode(39)+vciu+String.fromCharCode(39)+','+String.fromCharCode(39)+data[i].sn+String.fromCharCode(39)+','+idsaleorders+')">&nbsp;&nbsp;&nbsp;<i class="fas fa-print"></i></a>';	
						}
						if (data[i].tienefinalchk !="")
						{
						//eTable= eTable+" <span data-toggle='tooltip'  class='float-right'><span data-toggle='tooltip' title='' class='badge bg-success'>Final Chk MARCO</span></span> <div id='collapse"+idsaleorders+vciu+data[i].sn+"' name id='collapse"+idsaleorders+vciu+data[i].sn+"' class='panel-collapse in collapse'></div>";											
						//det_modules=" <a href='#' target='_blanck'>View WO Calibration <i class='far fa-eye'></i> </a>";
						}
						
						
						eTable += " <div id='collapse"+idsaleorders+vciu+data[i].sn+data[i].idband+"' name='collapse"+idsaleorders+vciu+data[i].sn+data[i].idband+"' class='panel-collapse in collapse container ' style='background-color:#E1F5FE'> "+det_modules+" </div>";	
						eTable += "</tr>";
						 det_modules="";
					  }
					  eTable +="</tbody></table></div>";
					 
					//  console.log ('collapse'+vciunomdiv);
					  $('#collapse'+vciunomdiv).html(eTable);
					 
					
				}
			});
		}
   }
   
    function show_ciu(idsaleorders, nameSO_Customers)
   {
	   var lbl_color ="";
	   var datosrefapasar="";
		//alert('hi' + $('#collapse'+idsaleorders).is(":hidden"));
		if ($('#collapse'+idsaleorders).is(":hidden") == true)
		{
		
			$('#collapse'+idsaleorders).html("<p name='msjwaitparticular' id='msjwaitparticular' align='center'><img src='img/waitazul.gif' width='100px' ></p>");
			//	console.log(idsaleorders);
				toastr.options = {
				  "closeButton": false,
				  "debug": false,
				  "newestOnTop": false,
				  "progressBar": true,
				  "positionClass": "toast-bottom-right",
				  "preventDuplicates": false,
				  "onclick": null,
				  "showDuration": "600",
				  "hideDuration": "600",
				  "timeOut": "600",
				  "extendedTimeOut": "600",
				  "showEasing": "swing",
				  "hideEasing": "linear",
				  "showMethod": "fadeIn",
				  "hideMethod": "fadeOut"
				};	
				toastr["success"]("Wait....Search Results", "Attention :: Sales Orders ");
				$.ajax
				({ 
					url: 'ajax_show_CIU.php',
					data: "idsaleorders="+idsaleorders,	
					type: 'post',				
					datatype:'JSON',
				
					success: function(data)
					{
						 $("#msjwait").hide();	
						// console.log("devolvio"+ idsaleorders+ data);
						  var eTable="<div class='card-headermarco'>";					
						  for(var i=0; i<data.length;i++)
						  {
							
							lbl_color ="bg-red";
							  if (data[i].cantdib >=1 )
							  {
								  	lbl_color ="bg-warning";
							  }
							   if (data[i].cantcalib >=1 )
							  {
								  	lbl_color ="bg-info";
							  }
							   if (data[i].cantfinalchk >=1 )
							  {
								  	lbl_color ="bg-green";
							  }
							  
							
												  
						  datosrefapasar=  '"ID SO:' + idsaleorders + '- Ciu:'+ data[i].ciu + '-SO:'+nameSO_Customers.trim()+ '"';
							
							eTable += "<a data-toggle='collapse' data-parent='#accordion' onclick="+"show_CIU_SN("+idsaleorders+",'"+data[i].ciu+"','"+idsaleorders+data[i].ciu_sincara+"','"+nameSO_Customers.trim()+"') href='#collapse"+idsaleorders+data[i].ciu_sincara+"' aria-expanded='true'><img src='img/imgciu.jpg' width='40px' > "+data[i].ciu+"&nbsp;<span data-toggle='tooltip' class='badge "+ lbl_color +" mb-2 labelsom'> &nbsp;[ &nbsp;"+data[i].cant_sn+" SN &nbsp;] </span>";
								eTable +=' &nbsp;&nbsp;<a href="#" onclick="Call_printlabel_todos('+String.fromCharCode(39)+data[i].ciu+String.fromCharCode(39)+','+idsaleorders+')">&nbsp;<i class="fas fa-tasks"></i>&nbsp;<i class="fas fa-print"></i></a>';
							eTable +=" &nbsp;&nbsp;  <a href='#'  onclick='callsupportit(1,"+datosrefapasar+")' style='color:#0053a1;font-size: 12px;' )> <i class='fas fa-question-circle'></i>&nbspRequire Support</a></span></a>&nbsp; <br><div id='collapse"+idsaleorders+data[i].ciu_sincara+"' name id='collapse"+idsaleorders+data[i].ciu_sincara+"' class='panel-collapse in collapse'> ... </div>";
							
							/*
									eTable += "<a data-toggle='collapse' data-parent='#accordion' onclick="+"show_CIU_SN("+idsaleorders+",'"+data[i].ciu+"','"+idsaleorders+data[i].ciu_sincara+"','"+nameSO_Customers.trim()+"') href='#collapse"+idsaleorders+data[i].ciu_sincara+"' aria-expanded='true'><img src='img/imgciu.jpg' width='40px' > "+data[i].ciu+"&nbsp;<span data-toggle='tooltip' class='badge "+ lbl_color +" mb-2 labelsom'> &nbsp;[ &nbsp;"+data[i].cant_sn+" SN &nbsp;]";
							
						
						//	etable +=" <a href='#'  onclick='callsupportit(1,"+datosrefapasar+")' style='color:#0053a1;font-size: 12px;' )> <i class='fas fa-question-circle'></i>&nbspRequire Support</a></span></a>&nbsp; <br><div id='collapse"+idsaleorders+data[i].ciu_sincara+"' name id='collapse"+idsaleorders+data[i].ciu_sincara+"' class='panel-collapse in collapse'> ... </div>";
							
							
							*/
																			
						  }
						  eTable +="</div>";
						  $('#collapse'+idsaleorders).html(eTable);
					}
					/* error: function (xhr, ajaxOptions, thrownError) {
						console.log(xhr.status);
						console.log(thrownError);
						$('#collapse'+idsaleorders).html("<p name='msjwaitparticular' id='msjwaitparticular' align='center'>Error by Ajax Conector</p>");
					  }*/
				});
			}	
   }
   
   function show_ciu_search(idsaleorders, nameSO_Customers)
   {
	      var lbl_color ="";
				$("#divgeneralinfo").addClass('d-none');
				$("#divgeneralinfoparam").addClass('d-none');
				$("#divdetinfolog").addClass('d-none');
				
				$("#diveq").addClass('d-none');
				$("#divfactory").addClass('d-none');
				$("#divfinalcheck").addClass('d-none');
				$("#divgroupbyciu").addClass('d-none');
				
					$("#divgeneralinfo").removeClass('d-none');
				$("#divgeneralinfoparam").removeClass('d-none');
				$("#divdetinfolog").removeClass('d-none');
				
		//alert('hi' + $('#collapse'+idsaleorders).is(":hidden"));
	//	if ($('#collapse'+idsaleorders).is(":hidden") == true)
	//	{
		
			$('#collapse'+idsaleorders).html("<p name='msjwaitparticular' id='msjwaitparticular' align='center'><img src='img/waitazul.gif' width='100px' ></p>");
			//	console.log(idsaleorders);
			/*	toastr.options = {
				  "closeButton": false,
				  "debug": false,
				  "newestOnTop": false,
				  "progressBar": true,
				  "positionClass": "toast-bottom-right",
				  "preventDuplicates": false,
				  "onclick": null,
				  "showDuration": "600",
				  "hideDuration": "600",
				  "timeOut": "600",
				  "extendedTimeOut": "600",
				  "showEasing": "swing",
				  "hideEasing": "linear",
				  "showMethod": "fadeIn",
				  "hideMethod": "fadeOut"
				};	
				toastr["success"]("Wait....Search Results", "Attention :: Sales Orders ");*/
				   var lbl_color =" bg-red ";
				$.ajax
				({ 
					url: 'ajax_show_CIU.php',
					data: "idsaleorders="+idsaleorders,	
					type: 'post',				
					datatype:'JSON',				
                   cache:false,
					success: function(data)
					{
						 $("#msjwait").hide();	
						 	// console.log("devolvio"+ idsaleorders+ data);
						  var eTable="<div class='card-headermarco'>";					
						  for(var i=0; i<data.length;i++)
						  {
							
							if ($("[type=search]" ).val() !="")
								{
									///estamos en busqueda..
									//console.log(  data[i].arraysn );
									var testStr = data[i].arraysn;
									var testStr1 = data[i].ciu;
									
								//	console.log( "VAMos x SN  testStr:" + testStr );
									var textoabuscar= $("[type=search]" ).val().toUpperCase().trim();
									if(testStr.includes(textoabuscar) || testStr1.includes(textoabuscar) ){
								////	console.log( "testStr encontrado:" + testStr );
								//acamarcocantdib
								lbl_color ="bg-red";
									if (data[i].cantdib >=1 )
									  {
											lbl_color ="bg-warning";
									  }
									   if (data[i].cantcalib >=1 )
									  {
											lbl_color ="bg-info";
									  }
									   if (data[i].cantfinalchk >=1 )
									  {
											lbl_color ="bg-green";
									  }
										
								
									eTable += "<a data-toggle='collapse' data-parent='#accordion' onclick="+"show_CIU_SN_search("+idsaleorders+",'"+data[i].ciu+"','"+idsaleorders+data[i].ciu_sincara+"','"+nameSO_Customers.trim()+"') href='#collapse"+idsaleorders+data[i].ciu_sincara+"' aria-expanded='true'><img src='img/imgciu.jpg' width='40px' > "+data[i].ciu+"&nbsp;<span data-toggle='tooltip' class='badge "+lbl_color+" mb-2 labelsom'> &nbsp;[ &nbsp;"+data[i].cant_sn+" SN &nbsp;] &nbsp; </span></a>&nbsp; <br><div id='collapse"+idsaleorders+data[i].ciu_sincara+"' name id='collapse"+idsaleorders+data[i].ciu_sincara+"' class='panel-collapse in collapse'> ... </div>";	
																		
										show_CIU_SN_search(idsaleorders,data[i].ciu, idsaleorders+data[i].ciu_sincara,nameSO_Customers.trim());
										var collapse_snaabrir= idsaleorders+data[i].ciu_sincara;
										setTimeout(function(){
											if ($('#collapse'+collapse_snaabrir	).is(":hidden") == true)
											{
												$("#collapse"+ collapse_snaabrir).collapse('toggle');
											}
									//		console.log("Collapose IdSO Nro:"+ collapse_snaabrir);
										}, 1500);
				
									
									}
									
								}
							else
							{
							eTable += "<a data-toggle='collapse' data-parent='#accordion' onclick="+"show_CIU_SN_search("+idsaleorders+",'"+data[i].ciu+"','"+idsaleorders+data[i].ciu_sincara+"','"+nameSO_Customers.trim()+"') href='#collapse"+idsaleorders+data[i].ciu_sincara+"' aria-expanded='true'><img src='img/imgciu.jpg' width='40px' > "+data[i].ciu+"&nbsp;<span data-toggle='tooltip' class='badge bg-warning mb-2 labelsom'> &nbsp;[ &nbsp;"+data[i].cant_sn+" SN &nbsp;] &nbsp; </span></a>&nbsp; <br><div id='collapse"+idsaleorders+data[i].ciu_sincara+"' name id='collapse"+idsaleorders+data[i].ciu_sincara+"' class='panel-collapse in collapse'> ... </div>";	
							}
							//eTable += "<a data-toggle='collapse' data-parent='#accordion' href='#collapse"+idsaleorders+data[i].ciu_sincara+"' aria-expanded='true'><img src='img/imgciu.jpg' width='40px' > "+data[i].ciu+"<span data-toggle='tooltip' class='badge bg-warning mb-2 labelsom'> &nbsp;[ &nbsp;"+data[i].cant_sn+" SN &nbsp;] &nbsp; </span></a><a href='#' onclick='show_CIU_SN("+idsaleorders+","+data[i].ciu+","+idsaleorders+data[i].ciu_sincara+"')'><i class='nav-icon fas fa-chart-line'> </i>	</a> <br><div id='collapse"+idsaleorders+data[i].ciu_sincara+"' class='panel-collapse in collapse'> </div>";
							
							
																			
						  }
						  eTable +="</div>";
						  $('#collapse'+idsaleorders).html(eTable);
						 // console.log("agrego table"+ eTable);
					}
					/* error: function (xhr, ajaxOptions, thrownError) {
						console.log(xhr.status);
						console.log(thrownError);
						$('#collapse'+idsaleorders).html("<p name='msjwaitparticular' id='msjwaitparticular' align='center'>Error by Ajax Conector</p>");
					  }*/
				});
		//	}	
   }
   
   function show_CIU_SN_details(idsaleorders, vciu, vciunomdiv,cciu_sn, name_show_customerSO,cuantoamuestro)
   {
	  // console.log(idsaleorders+vciu+vciunomdiv+cciu_sn);
	   //if ($('#collapse'+vciunomdiv).is(":hidden") == true)
		//{
			//mostramos los datos del SN band
		//console.log("es aca");
		$("#divgeneralinfo").addClass('d-none');
				$("#divgeneralinfoparam").addClass('d-none');
				$("#divdetinfolog").addClass('d-none');
				
				$("#diveq").addClass('d-none');
				$("#divfactory").addClass('d-none');
				$("#divfinalcheck").addClass('d-none');
				$("#divgroupbyciu").addClass('d-none');
					$("#divscripttime").addClass('d-none');
		
		$("#divgeneralinfoparam").removeClass('d-none');
		
			$("#divgeneralinfo").removeClass('d-none');
			$("#divdetinfolog").removeClass('d-none');
	
			show_info_log(vciu,cciu_sn,name_show_customerSO,cuantoamuestro)
	//	}	
   }
     function show_CIU_SN_details2020(idsaleorders, vciu, vciunomdiv,cciu_sn, name_show_customerSO,cuantoamuestro)
   {
	  // console.log(idsaleorders+vciu+vciunomdiv+cciu_sn);
	   //if ($('#collapse'+vciunomdiv).is(":hidden") == true)
		//{
			//mostramos los datos del SN band
		//console.log("es aca");
		$("#divgeneralinfo").addClass('d-none');
				$("#divgeneralinfoparam").addClass('d-none');
				$("#divdetinfolog").addClass('d-none');
					$("#divscripttime").addClass('d-none');
				$("#diveq").addClass('d-none');
				$("#divfactory").addClass('d-none');
				$("#divfinalcheck").addClass('d-none');
				$("#divgroupbyciu").addClass('d-none');
		
		$("#divgeneralinfoparam").removeClass('d-none');
			$("#divgeneralinfo").removeClass('d-none');
			$("#divdetinfolog").removeClass('d-none');
		
		
			show_info_log2020(vciu,cciu_sn,name_show_customerSO,cuantoamuestro, idsaleorders)
	//	}	
   }
   
  function show_CIU_SN(idsaleorders, vciu, vciunomdiv,name_show_customerSO,cuantasrev)
   {
	   var ifdualband="";
	   if ($('#collapse'+vciunomdiv).is(":hidden") == true)
		{

 
		//	console.log(idsaleorders);
			toastr.options = {
			  "closeButton": false,
			  "debug": false,
			  "newestOnTop": false,
			  "progressBar": true,
			  "positionClass": "toast-bottom-right",
			  "preventDuplicates": false,
			  "onclick": null,
			  "showDuration": "600",
			  "hideDuration": "600",
			  "timeOut": "600",
			  "extendedTimeOut": "600",
			  "showEasing": "swing",
			  "hideEasing": "linear",
			  "showMethod": "fadeIn",
			  "hideMethod": "fadeOut"
			};	
			toastr["success"]("Wait....Search Results", "Attention :: State of Sale Orders ");
	   
			$.ajax
			({ 
				url: 'ajax_show_CIU_SN.php',
				data: "idsaleorders="+idsaleorders+"&vciu="+vciu+"&qs="+cuantasrev,	
				type: 'post',				
				datatype:'JSON',
				success: function(data)
				{
				//	alert(data);
					
					//detallelog
					 $("#msjwait").hide();				 
					
					  var eTable="<div class='container'><table class='table  table-bordered table-striped table-sm'><tbody>";
					  var det_modules="";
					  var detband = "0";
					
					  for(var i=0; i<data.length;i++)
					  {
						
						
						//<span data-toggle='tooltip'  class='float-right'> &nbsp; <span data-toggle='tooltip' title='1 Calibration' class='badge bg-warning'>Dig. Mod</span>&nbsp;
						//<span data-toggle='tooltip' title='3 Calibration' class='badge bg-primary'>Calib [3]</span>&nbsp;
						//<span data-toggle='tooltip' title='3 Calibration' class='badge bg-success'>Acept [1] </span>
						//<span data-toggle='tooltip' title='3 Calibration' class='badge bg-danger'>Final Chk</span></span> <div id='collapse"+idsaleorders+vciu+data[i].sn+"' name id='collapse"+idsaleorders+vciu+data[i].sn+"' class='panel-collapse in collapse'> ... </div>
						if (data[i].ifdualband ==1)
						{
							ifdualband="";
						
						}
						else
						{
							if (data[i].idband==0)
							{
								ifdualband = "&nbsp;<i class='fas fa-grip-lines-vertical'></i> Band: 700 " ;
								var detband = " [Band:700]";
							}
							if (data[i].idband==1)							
							{
								var detband = "[Band:800]";
							ifdualband = "&nbsp;<i class='fas fa-grip-lines-vertical'></i> Band: 800 " ;	
							}
							
						
						}
						eTable += "<tr >";
						eTable += "<td> <a data-toggle='collapse' data-parent='#accordion' onclick="+"show_CIU_SN_details("+idsaleorders+",'"+vciu+"','"+idsaleorders+vciu+data[i].sn+data[i].idband+"','"+data[i].sn+"','"+name_show_customerSO+"',1) href='#collapse"+idsaleorders+vciu+data[i].sn+data[i].idband+"' aria-expanded='true'><i class='nav-icon fas fa-th'></i> "+data[i].sn+ifdualband+"</a>&nbsp&nbsp&nbsp;"; 
						
						eTable +='';	
						if (data[i].sn_modulo !="")
						{
							//acamarco33
							det_modules+= '<i  class="fas fa-sliders-h"></i> Digital Module '+data[i].sn_modulo+' '+detband+' <a href="#" onclick="mostrar_digmod('+"'"+data[i].sn_modulo.trim()+"','"+data[i].sn+"'"+')"> <i class="fas fa-eye"></i></a> <br>';
							eTable +=' <a href="#" onclick="Call_printlabel('+String.fromCharCode(39)+vciu+String.fromCharCode(39)+','+String.fromCharCode(39)+data[i].sn+String.fromCharCode(39)+','+idsaleorders+')">&nbsp;<i class="fas fa-print"></i></a>';
							eTable +="<span data-toggle='tooltip'  class='float-right'> &nbsp; <span data-toggle='tooltip' class='badge badge-pill bg-warning'>Dig. Mod ["+data[i].countdigm+"]&nbsp;"
							
							if (data[i].totalpassdig == "true") 
							{
								eTable+= " <i class='fas fa-check'></i></span>" ; 
							} 
							else
							{
								eTable+= "</span>";
							}
							
							if (data[i].sn_modulocalif !="")
							{
								if( data[i].calib2dagener== "Y")
								{
									det_modules+= '<i class="fas fa-tools"></i> Calibration '+data[i].sn_modulocalif+'  '+detband+' <a href="#"  onclick="mostrar_digmodcalib('+"'"+data[i].sn_modulo.trim()+"','"+data[i].sn+"'"+')"> &nbsp;<i class="fas fa-eye"></i>&nbsp;</a> - <a href="#" onclick="openpopupframe('+"'"+data[i].sn_modulo.trim()+"','"+data[i].sn+"'"+')"> <i class="fas fa-sliders-h"></i> See results </a> <br>';
								}
								else
								{
									det_modules+= '<i class="fas fa-tools"></i> Calibration '+data[i].sn_modulocalif+'  '+detband+' <a href="#"  onclick="mostrar_digmodcalib('+"'"+data[i].sn_modulo.trim()+"','"+data[i].sn+"'"+')"> &nbsp;<i class="fas fa-eye"></i>&nbsp;</a> <br>';
								}
									
								//det_modules+= '<i class="fas fa-tools"></i> Calibration '+data[i].sn_modulocalif+'  '+detband+' <a href="#"  onclick="mostrar_digmodcalib('+"'"+data[i].sn_modulo.trim()+"','"+data[i].sn+"'"+')"> &nbsp;<i class="fas fa-eye"></i>&nbsp;</a> - <a href="#" onclick="openpopupframe('+"'"+data[i].sn_modulo.trim()+"','"+data[i].sn+"'"+')"> <i class="fas fa-sliders-h"></i> See results </a> <br>';
								eTable +="&nbsp;&nbsp;<span data-toggle='tooltip' class='badge bg-info'>Calib ["+data[i].countdigmcalif+"]&nbsp;"	
								if (data[i].totalpassdigcalif == "true") 
								{
									eTable+= " <i class='fas fa-check'></i></span>"; 
								} 
								else
								{
									eTable+= "</span>";
								}
							
								
							}
							if (data[i].sn_modulocaliffnchk !="")
							{
								
								det_modules+= '<i class="far fa-check-square"></i> Final Check '+data[i].sn_modulocaliffnchk+'  '+detband+' <a href="#" onclick="mostrar_digmodcalibfinalcheck('+"'"+data[i].sn_modulo.trim()+"','"+data[i].sn+"'"+')"> &nbsp;<i class="fas fa-eye"></i>&nbsp;</a><br>';
								eTable +="&nbsp;&nbsp;<span data-toggle='tooltip' title='3 ' class='badge bg-green'>Final Chk ["+data[i].countdigmcaliffnchk+"]&nbsp;"	
								if (data[i].totalpassdigcaliffnchk == "true") 
								{
									eTable+= " <i class='fas fa-check'></i></span>"; 
								} 
								else
								{
									eTable+= "</span>";
								}
								
								
							}
																							
						}
						else
						{
							eTable +="<span data-toggle='tooltip'  class=''> &nbsp; ";
							eTable +='<a href="#" onclick="Call_printlabel('+String.fromCharCode(39)+vciu+String.fromCharCode(39)+','+String.fromCharCode(39)+data[i].sn+String.fromCharCode(39)+','+idsaleorders+')">&nbsp;<i class="fas fa-print"></i></a>';
						}
						
						
						
						
						
						
						eTable += " </span><div id='collapse"+idsaleorders+vciu+data[i].sn+data[i].idband+"' name='collapse"+idsaleorders+vciu+data[i].sn+data[i].idband+"' class='panel-collapse in collapse container ' style='background-color:#E1F5FE'> "+det_modules+" </div>";	
						eTable += "</tr>";
						 det_modules="";
					  }
					  eTable +="</tbody></table></div>";
					 
					//  console.log ('collapse'+vciunomdiv);
					  $('#collapse'+vciunomdiv).html(eTable);
					 
					
				}
			});
		}
   }
   
   

function div_y_tabla_ocultas()
{
	
	/*$("#divgeneralinfo").addClass('d-none');
	$("#divgeneralinfoparam").addClass('d-none');
	$("#divdetinfolog").addClass('d-none');
	$("#diveq").addClass('d-none');
	$("#divfactory").addClass('d-none');
	$("#divfinalcheck").addClass('d-none');
	$("#divscripttime").addClass('d-none');
	*/
	
	$("#divgroupbyciu").addClass('d-none');
	$("#myTabledib").addClass('d-none');
	$("#myTabledibfw").addClass('d-none');
	$("#myTabledibsn").addClass('d-none');
	$("#myTabledibciu").addClass('d-none');
	$("#myTablecaliffw").addClass('d-none');
	$("#myTablecalifsn").addClass('d-none');
	$("#myTablecalifciu").addClass('d-none');
	$("#myTablecaliffreq").addClass('d-none');
	$("#myTabletimescript").addClass('d-none');
	$("#myTablecalibscripttime").addClass('d-none');
	$("#infolog").addClass('d-none');
	$("#div_calib_eq").addClass('d-none');
	$("#div_calib_fact").addClass('d-none');
	$("#div_calib_finalcheck").addClass('d-none');
	$("#div_scripttime").addClass('d-none');
}
   
    function show_CIU_SN_search(idsaleorders, vciu, vciunomdiv,name_show_customerSO,cuantasrev)
   {
	   var ifdualband="";
	  // if ($('#collapse'+vciunomdiv).is(":hidden") == true)
		//{

 
		//	console.log(idsaleorders);
		/*	toastr.options = {
			  "closeButton": false,
			  "debug": false,
			  "newestOnTop": false,
			  "progressBar": true,
			  "positionClass": "toast-bottom-right",
			  "preventDuplicates": false,
			  "onclick": null,
			  "showDuration": "600",
			  "hideDuration": "600",
			  "timeOut": "600",
			  "extendedTimeOut": "600",
			  "showEasing": "swing",
			  "hideEasing": "linear",
			  "showMethod": "fadeIn",
			  "hideMethod": "fadeOut"
			};	
			toastr["success"]("Wait....Search Results", "Attention :: State of Sale Orders ");*/
	   
			$.ajax
			({ 
				url: 'ajax_show_CIU_SN.php',
				data: "idsaleorders="+idsaleorders+"&vciu="+vciu+"&qs="+cuantasrev,	
				type: 'post',				
				datatype:'JSON',
				success: function(data)
				{
				//	alert(data);
					
					//detallelog
					 $("#msjwait").hide();				 
					
					  var eTable="<div class='container'><table class='table  table-bordered table-striped table-sm'><tbody>";
					  var det_modules="";
					  var detband = "0";
					
					  for(var i=0; i<data.length;i++)
					  {
						
						
						//<span data-toggle='tooltip'  class='float-right'> &nbsp; <span data-toggle='tooltip' title='1 Calibration' class='badge bg-warning'>Dig. Mod</span>&nbsp;
						//<span data-toggle='tooltip' title='3 Calibration' class='badge bg-primary'>Calib [3]</span>&nbsp;
						//<span data-toggle='tooltip' title='3 Calibration' class='badge bg-success'>Acept [1] </span>
						//<span data-toggle='tooltip' title='3 Calibration' class='badge bg-danger'>Final Chk</span></span> <div id='collapse"+idsaleorders+vciu+data[i].sn+"' name id='collapse"+idsaleorders+vciu+data[i].sn+"' class='panel-collapse in collapse'> ... </div>
						if (data[i].ifdualband ==1)
						{
							ifdualband="";
						
						}
						else
						{
							if (data[i].idband==1)
							{
								ifdualband = "&nbsp;<i class='fas fa-grip-lines-vertical'></i> Band: 700 " ;
								var detband = "700";
							}
							if (data[i].idband==2)							
							{
								var detband = "800";
							ifdualband = "&nbsp;<i class='fas fa-grip-lines-vertical'></i> Band: 800 " ;	
							}
							
						
						}
						var mostrarelsn="N";
						if ($("[type=search]" ).val() !="")
								{
									// buscamos x el dato ingresado.
									var testStr = data[i].sn;
									var testStr1 = vciu;
									
									//console.log( "testStr:" + testStr );
									var textoabuscar= $("[type=search]").val().toUpperCase().trim() ;
									if(testStr.includes(textoabuscar) || testStr1.includes(textoabuscar)){
										mostrarelsn="S";
									}
								}
						eTable += "<tr >";
						if (mostrarelsn=="S")
						{
						eTable += "<td> <a data-toggle='collapse' data-parent='#accordion' onclick="+"show_CIU_SN_details("+idsaleorders+",'"+vciu+"','"+idsaleorders+vciu+data[i].sn+data[i].idband+"','"+data[i].sn+"','"+name_show_customerSO+"',1) href='#collapse"+idsaleorders+vciu+data[i].sn+data[i].idband+"' aria-expanded='true'><i class='nav-icon fas fa-th'></i> "+data[i].sn+ifdualband+"</a> ";	
						
						if (data[i].sn_modulo !="")
						{
							//det_modules+= "<i  class='fas fa-sliders-h'></i> Digital Module "+data[i].sn_modulo+" [Band "+detband+"] <a href='#'>&nbsp;<i class='fas fa-eye'></i>&nbsp;</a><br>";
							det_modules+= '<i  class="fas fa-sliders-h"></i> Digital Module '+data[i].sn_modulo+' [Band '+detband+'] <a href="#" onclick="mostrar_digmod('+"'"+data[i].sn_modulo.trim()+"','"+data[i].sn+"'"+')"> <i class="fas fa-eye"></i></a><br>';
							
								eTable +="<span data-toggle='tooltip'  class='float-right'> &nbsp; <span data-toggle='tooltip' class='badge badge-pill bg-warning'>Dig. Mod ["+data[i].countdigm+"]&nbsp;"
								
								
								if (data[i].totalpassdig == "true") 
								{
									eTable+= " <i class='fas fa-check'></i></span>" ; 
								} 
								else
								{
									eTable+= "</span>";
								}
							
							
							if (data[i].sn_modulocalif !="")
							{
								det_modules+= '<i class="fas fa-tools"></i> Calibration '+data[i].sn_modulocalif+' [Band '+detband+'] <a href="#"  onclick="mostrar_digmodcalib('+"'"+data[i].sn_modulo.trim()+"','"+data[i].sn+"'"+')"> &nbsp;<i class="fas fa-eye"></i>&nbsp;</a><br>';	
								
								eTable +="&nbsp;&nbsp;<span data-toggle='tooltip' class='badge bg-green'>Calib ["+data[i].countdigmcalif+"]&nbsp;"	
								if (data[i].totalpassdigcalif == "true") 
								{
									eTable+= " <i class='fas fa-check'></i></span>"; 
								} 
								else
								{
									eTable+= "</span>";
								}
								
								
							}
							if (data[i].sn_modulocaliffnchk !="")
							{
								
								det_modules+= '<i class="far fa-check-square"></i> Final Check '+data[i].sn_modulocaliffnchk+' [Band '+detband+'] <a href="#" onclick="mostrar_digmodcalibfinalcheck('+"'"+data[i].sn_modulo.trim()+"','"+data[i].sn+"'"+')"> &nbsp;<i class="fas fa-eye"></i>&nbsp;</a><br>';
								eTable +="&nbsp;&nbsp;<span data-toggle='tooltip' title='3 Calibration' class='badge bg-danger'>Final Chk ["+data[i].countdigmcaliffnchk+"]&nbsp;"	
								if (data[i].totalpassdigcaliffnchk == "true") 
								{
									eTable+= " <i class='fas fa-check'></i></span>"; 
								} 
								else
								{
									eTable+= "</span>";
								}
								
								
							}
																							
						}
						else
						{
							eTable +="<span data-toggle='tooltip'  class='float-right'> &nbsp; "
						}
						//fin if mostrar
						}
						
						
						
						
						
						eTable += " </span><div id='collapse"+idsaleorders+vciu+data[i].sn+data[i].idband+"' name='collapse"+idsaleorders+vciu+data[i].sn+data[i].idband+"' class='panel-collapse in collapse container ' style='background-color:#E1F5FE'> "+det_modules+" </div>";	
						eTable += "</tr>";
						 det_modules="";
					  }
					  eTable +="</tbody></table></div>";
					 
					//  console.log ('collapse'+vciunomdiv);
					  $('#collapse'+vciunomdiv).html(eTable);
					 
					
				}
			});
		//}
   }



function json2array(json){
    var result = [];
    var keys = Object.keys(json);
    keys.forEach(function(key){
        result.push(json[key]);
    });
    return result;
}
/////auto add column
		function AddNewCol(colNum, datos)
        {
            var myTable = $('#myTable');
            var colCount = myTable.find('td[data-row=0]').length;
            var rowCount = $("#myTable tr").length;
 
            //incriment id numbers to make room for the new column
            myTable_IncrimentColIdNumber(colNum, 1);
			
			var arram = [];
			 arram.push( json2array(datos));
			//console.log ("arraycolumno"+arram[0][2]);
			
            //add new column by adding a new cell to each row
            for (row = 0; row < rowCount; row++) {
                //add a new cell after the cell for the previous column
				//console.log ("arraycolumno"+arram[0][row]);
                $('td[data-row=' + row + '][data-col=' + (parseInt(colNum)-1) + ']').after('<td data-row="'+ row +'" data-col="' +colNum+ '"> '+arram[0][row]+'</td>');
            }
        }
		
		function myTable_DelRow(row) {
				$('tr[data-row=' + row + ']').remove();
			 
				myTable_IncrimentRowIdNumber(row, -1);
			}
			
			function myTableUnit_DelRow(row) {
				$('tr[data-rowul=' + row + ']').remove();
			 
				myTable_IncrimentRowIdNumber(row, -1);
			}
			
				function myTabledpx_DelRow(row) {
				$('tr[data-rowsubband=' + row + ']').remove();
			 
				myTable_IncrimentRowIdNumber(row, -1);
			}
			
			function myTable_DelRowchanel(row) {
				$('tr[data-rowchanel=' + row + ']').remove();
			 
				myTable_IncrimentRowIdNumber(row, -1);
			}
			
			
 
		function myTable_DelCol(col) {
			$('td[data-col=' + parseInt(col) + ']').remove();
			myTable_IncrimentColIdNumber(col, -1);
		}
		
		function myTable_DelColchanel(col) {
			$('td[data-colchanel=' + parseInt(col) + ']').remove();
			myTable_IncrimentColIdNumber(col, -1);
		}
 
		function myTable_IncrimentColIdNumber(startPosition, increment) {
 
            //increment column id's
            var cells = $('myTable td[data-col]');
 
            //foreach cell
            for (i = 0; i < cells.length ; i++) {
 
                var colNum = parseInt(cells.eq(i).attr('data-col'));
 
                //for every column beyond the insertion point, increment the column number
                if (colNum >= startPosition) {
                    var newId = colNum + parseInt(increment);
                    cells.eq(i).attr('data-col', newId);
                }
            }
        }
		
		function myTable_IncrimentRowIdNumber(startPosition, increment) {
            //get all the items with the data-row attr. - this will include tr and td
            var items = $('[data-row]');
 
            //for each item with a data-row attr. increment the value
            for (i = 0; i < items.length; i++) {
                //get the current value
                var rowNum = parseInt(items.eq(i).attr('data-row'));
 
                //only update the rows that are after the new inserted row
                if (rowNum >= startPosition) {
                    //generate the new value and update the item
                    var newId = rowNum + parseInt(increment);
                    items.eq(i).attr('data-row', newId);
                }
            }
        }
		
		function AddNewRow(row) {
            //using jquery, grab a reference to the html table
            var myTable = $('#myTable');
            //get the number of rows and columns
            var colCount = myTable.find('generalinfo, td[data-row=0]').length;
            var rowCount = $("#myTable tr").length;
 
            //incriment position numbers to make room for the new row
            //this is required to keep things working after we change the table
            myTable_IncrimentRowIdNumber(row, 1);
 
            //add row
            var newRow = '<tr data-row="' + row + '">';
            //add cells into the row
            for (addCol = 0; addCol < colCount; addCol++) {
                newRow += '<td data-row="'+ row +'" data-col="' +addCol+ '"> </td>';
            }
            //close the row
            newRow += '</tr>';
            //add the new row after the previous row in the table - the magic of jquery :)
            $(newRow).insertAfter('generalinfo, tr[data-row=' + (parseInt(row) - 1) + ']');
        }
		
			function AddNewRowchanel(row,datos,addnomtablemodif) {
            //using jquery, grab a reference to the html table
            var myTable = $('#myTablechanel');
            //get the number of rows and columns
            var colCount = myTable.find('td[data-rowchanel=0]').length;
            var rowCount = $("#myTablechanel tr").length;
 
            //incriment position numbers to make room for the new row
            //this is required to keep things working after we change the table
            myTable_IncrimentRowIdNumber(row, 1);
			//console.log("nuevo row CHANEL");
			var arramch = [];
			 arramch.push( json2array(datos));
            //add row
            var newRow = '<tr data-rowchanel="' + row + '">';
            //add cells into the row
            for (addCol = 0; addCol < colCount; addCol++) {
                newRow += '<td data-rowchanel="'+ row +'" data-colchanel="' +addCol+ '">'+arramch[0][row]+' </td>';
            }
            //close the row
            newRow += '</tr>';
            //add the new row after the previous row in the table - the magic of jquery :)
            $(newRow).insertAfter('tr[data-rowchanel=' + (parseInt(row) - 1) + ']');
        }
		
		
		///funciones para DL
		/////auto add column
function AddNewColdl(colNum, datos,addnomtablemodif)
        {
            var myTable = $('#myTable'+addnomtablemodif);
            var colCount = myTable.find('td[data-row'+addnomtablemodif+'=0]').length;
            var rowCount = $("#myTable"+addnomtablemodif+" tr").length;  var rowCount = $("#myTable"+addnomtablemodif+" tr").length;
 
            //incriment id numbers to make room for the new column
            myTable_IncrimentColIdNumberdl(colNum, 1,addnomtablemodif);
			
			var arram = [];
			 arram.push( json2array(datos));
			///console.log ('aaaa:'+arram[0][2]);
			var tempcontador = 0;
		
            //add new column by adding a new cell to each row
            for (row = 0; row < rowCount; row++) {
                //add a new cell after the cell for the previous column
			
				if (row==0)
				{
				$('td[data-row'+addnomtablemodif+'=' + row + '][data-col'+addnomtablemodif+'=' + (parseInt(colNum)-1) + ']').after('<td data-row'+addnomtablemodif+'="'+ row +'" data-col'+addnomtablemodif+'="' +colNum+ '" class="table-info"> '+arram[0][row]+'</td>');	
				}
				else
				{
					if (arram[0][row] == '')
					{
						
						cantunitfremostradas = cantunitfremostradas + 1 ;	
						
					}
					
					
				$('td[data-row'+addnomtablemodif+'=' + row + '][data-col'+addnomtablemodif+'=' + (parseInt(colNum)-1) + ']').after('<td data-row'+addnomtablemodif+'="'+ row +'" data-col'+addnomtablemodif+'="' +colNum+ '" > '+arram[0][row]+'</td>');	
				}
                
            }
        }
		
		function AddNewColchanel(colNum, datos,addnomtablemodif)
        {
            var myTable = $('#myTable'+addnomtablemodif);
            var colCount = myTable.find('td[data-row'+addnomtablemodif+'=0]').length;
            var rowCount = $("#myTable"+addnomtablemodif+" tr").length;
 
            //incriment id numbers to make room for the new column
            myTable_IncrimentColIdNumberdl(colNum, 1,addnomtablemodif);
			
			var arram = [];
			var cantvacios=0;
			 arram.push( json2array(datos));
			//console.log ('new ro chanel:'+arram[0][2]+'-ch'+arram[0][1]);
			
            //add new column by adding a new cell to each row
            for (row = 0; row < rowCount; row++) {
                //add a new cell after the cell for the previous column
				//console.log('DAto a mostrar:'+arram[0][row]);
				if (arram[0][row]!= '')
				{
                $('td[data-row'+addnomtablemodif+'=' + row + '][data-col'+addnomtablemodif+'=' + (parseInt(colNum)-1) + ']').after('<td data-row'+addnomtablemodif+'="'+ row +'" data-col'+addnomtablemodif+'="' +colNum+ '"> '+arram[0][row]+'</td>');
				}
				else
				{
					cantvacios=cantvacios+1;
					myTable_DelRowchanel(row);
				}
            }
			
        }
		
		function AddNewColchanelsindato(colNum, datos,addnomtablemodif)
		{
			 var myTable = $('#myTable'+addnomtablemodif);
            var colCount = myTable.find('td[data-row'+addnomtablemodif+'=0]').length;
            var rowCount = $("#myTable"+addnomtablemodif+" tr").length;
 
            //incriment id numbers to make room for the new column
            myTable_IncrimentColIdNumberdl(colNum, 1,addnomtablemodif);
			
			var arram = [];
			 arram.push( json2array(datos));
			console.log ('new ro chanel:'+arram[0][2]+'-ch'+arram[0][1]);
			
            //add new column by adding a new cell to each row
            for (row = 0; row < rowCount; row++) {
                //add a new cell after the cell for the previous column
                $('td[data-row'+addnomtablemodif+'=' + row + '][data-col'+addnomtablemodif+'=' + (parseInt(colNum)-1) + ']').after('<td data-row'+addnomtablemodif+'="'+ row +'" data-col'+addnomtablemodif+'="' +colNum+ '">  </td>');
            }
		}
 
		function myTable_IncrimentColIdNumberdl(startPosition, increment,addnomtablemodif2) {
 
            //increment column id's
            var cells = $('myTable'+addnomtablemodif2+' td[data-col'+addnomtablemodif2+' ]');
 
            //foreach cell
            for (i = 0; i < cells.length ; i++) {
 
                var colNum = parseInt(cells.eq(i).attr('data-col'+addnomtablemodif2+' '));
 
                //for every column beyond the insertion point, increment the column number
                if (colNum >= startPosition) {
                    var newId = colNum + parseInt(increment);
                    cells.eq(i).attr('data-col'+addnomtablemodif2, newId);
                }
            }
        }


		function mostrar_digmodcalibfinalcheck(param_sn_modulo,param_sn_unit )
		{
			//habilitamos los div de los TAB
				$("#divgeneralinfo").addClass('d-none');
				$("#divgeneralinfoparam").addClass('d-none');
				$("#divdetinfolog").addClass('d-none');
				
				$("#diveq").addClass('d-none');
				$("#divfactory").addClass('d-none');
				$("#divfinalcheck").addClass('d-none');
				$("#divgroupbyciu").addClass('d-none');
				
					$("#divgeneralinfo").removeClass('d-none');
					$("#diveq").removeClass('d-none');
					$("#divfactory").removeClass('d-none');
					$("#divfinalcheck").removeClass('d-none');
					$("#divdetinfolog").removeClass('d-none');
						$("#divscripttime").removeClass('d-none');	
					$('#infolog').html(""); 
					var losbuttons= "";	
				
			
					$("#myTable").addClass('d-none');
					$("#myTablechanel").addClass('d-none');
					$("#myTableul").addClass('d-none');
					$("#myTablesubband").addClass('d-none');
				
					
					$("#myTabledib").addClass('d-none');
					$("#myTabledibciu").addClass('d-none');
					$("#myTabledibfw").addClass('d-none');
					$("#myTabledibsn").addClass('d-none');
					$("#myTabledibsn").addClass('d-none');
					$("#myTablecaliffw").addClass('d-none');
					$("#myTablecalifsn").addClass('d-none');
					$("#myTablecalifciu").addClass('d-none');
					$("#myTablecaliffreq").addClass('d-none');
					   
					
				
					var myTabledib = $("#myTabledib");
					myTabledib.html("<table id='myTabledib' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'><tr data-rowdib='0'><td data-rowdib='0' data-coldib='0' class='table-info'><b>GENERAL INFO</b> </td></tr><tr data-rowdib='1'><td data-rowdib='1' data-coldib='0'>Date</td></tr><tr data-rowdib='2'><td data-rowdib='2' data-coldib='0'>TotalTime </td></tr><tr data-rowdib='3'><td data-rowdib='3' data-coldib='0'>Calibratior </td></tr><tr data-rowdib='4'><td data-rowdib='4' data-coldib='0'>Station</td></tr><tr data-rowdib='5'><td data-rowdib='5' data-coldib='0'>FAS</td></tr><tr data-rowdib='6'><td data-rowdib='6' data-coldib='0'>Total Pass </td></tr></table>");
					
					var myTablecaliffw = $("#myTablecaliffw");
					myTablecaliffw.html("<table id='myTablecaliffw' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'><tr data-rowcaliffw='0'><td data-rowcaliffw='0' data-colcaliffw='0' class='table-info'><b>FWs</b> </td></tr>	<tr data-rowcaliffw='1'><td data-rowcaliffw='1' data-colcaliffw='0'>FW FPGA</td></tr><tr data-rowcaliffw='2'><td data-rowcaliffw='2' data-colcaliffw='0'>FW uC </td></tr><tr data-rowcaliffw='3'><td data-rowcaliffw='3' data-colcaliffw='0'>FW Rabb </td></tr><tr data-rowcaliffw='4'><td data-rowcaliffw='4' data-colcaliffw='0'>FW PAHP </td></tr></table>");
					
					var myTablecalifsn = $("#myTablecalifsn");
					myTablecalifsn.html("<table id='myTablecalifsn' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none '><tr data-rowcalifsn='0'><td data-rowcalifsn='0' data-colcalifsn='0' class='table-info'><b>SNs</b> </td></tr><tr data-rowcalifsn='1'><td data-rowcalifsn='1' data-colcalifsn='0'>SN DB</td></tr><tr data-rowcalifsn='2'><td data-rowcalifsn='2' data-colcalifsn='0'>SN Unit </td></tr><tr data-rowcalifsn='3'><td data-rowcalifsn='3' data-colcalifsn='0'>SN PALP </td></tr><tr data-rowcalifsn='4'><td data-rowcalifsn='4' data-colcalifsn='0'>SN PAHP </td></tr></table>");
					
					var myTablecalifciu = $("#myTablecalifciu");
					myTablecalifciu.html("<table id='myTablecalifciu' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'><tr data-rowcalifciu='0'><td data-rowcalifciu='0' data-colcalifciu='0' class='table-info'><b>CIUs</b> </td></tr><tr data-rowcalifciu='1'><td data-rowcalifciu='1' data-colcalifciu='0'>CIU DB</td></tr><tr data-rowcalifciu='2'><td data-rowcalifciu='2' data-colcalifciu='0'>CIU Unit </td></tr><tr data-rowcalifciu='3'><td data-rowcalifciu='3' data-colcalifciu='0'>CIU PALP</td></tr><tr data-rowcalifciu='4'><td data-rowcalifciu='4' data-colcalifciu='0'>CIU PAHP </td></tr></table>");
					
					var myTablecaliffreq = $("#myTablecaliffreq");
					myTablecaliffreq.html("<table id='myTablecaliffreq' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped d-none '><tr data-rowccaliffreq='0'><td data-rowcaliffreq='0' data-colcaliffreq='0' class='table-info'><b>Freqs</b> </td></tr><tr data-rowcaliffreq='1'><td data-rowcaliffreq='1' data-colcaliffreq='0'>UL Start</td></tr><tr data-rowcaliffreq='2'><td data-rowcaliffreq='2' data-colcaliffreq='0'>UL Stop </td></tr><tr data-rowcaliffreq='3'><td data-rowcaliffreq='3' data-colcaliffreq='0'>DL Start</td></tr><tr data-rowcaliffreq='4'><td data-rowcaliffreq='4' data-colcaliffreq='0'>DL Stop </td></tr></table>");
					
			$.ajax
			({ 
				url: 'aja_show_digmodcalif.php',
				data: "iddib_sn_modulo="+param_sn_modulo+"&idsunit="+param_sn_unit,	
				type: 'post',
				async:true,
                cache:false,
				success: function(data)
				{
					
					//var datax = JSON.parse(data)
					$('#ciusnshow').html( $('#ciusnshowbks').html() + ' &nbsp; FinalChk:  '+ param_sn_modulo); 
				    $("#msjwait").hide();
				 	
						$.each(data.gicalif, function(i, itemdib) {
							console.log('muestro CALIB...itemdib:'+itemdib.totalpass);
							AddNewColdl(1,itemdib,'dib');				
						});
					//	myTablecaliffw
						$.each(data.gicaliffw, function(i, itemcaliffw) {
							//console.log('muestro itemdibfw:'+itemdibfw.totalpass);
							AddNewColdl(1,itemcaliffw,'califfw');							
						});
						$.each(data.gicalisn, function(i, itemcalifsn) {
							//console.log('muestro itemdibfw:'+itemdibfw.totalpass);
							AddNewColdl(1,itemcalifsn,'califsn');							
						});
						$.each(data.gicaliciu, function(i, itemcalifciu) {
							//console.log('muestro itemdibfw:'+itemdibfw.totalpass);
							AddNewColdl(1,itemcalifciu,'califciu');							
						});
						$.each(data.gicalifreq, function(i, itemcaliffreq) {
							//console.log('muestro itemdibfw:'+itemdibfw.totalpass);
							AddNewColdl(1,itemcaliffreq,'califfreq');							
						});
						
						
						
						
						
						
						$.each(data.gilogcalif, function(i, itemlog) {
							console.log('muestro  califlog:'+itemlog.idlog);
							losbuttons = losbuttons + '<span class="badge badge-primary" onclick="show_log('+itemlog.idlog+')"><i class="fas fa-search"></i> Log DigMod: ('+itemlog.idlog+') </span> - ';	
													
						});
						
						//List to EQ
					//	console.log("Buscando eq");
						$('#div_calib_eq').html(""); 
							
							
							$('#div_calib_fact').html(""); 
							$.ajax
							({ 
								url: 'aja_show_digmodcalif_factory.php',
								data: "iddib_sn_modulo="+param_sn_modulo+"&idsunit="+param_sn_unit,	
								type: 'post',
								async:true,
								cache:false,
								success: function(data3)
								{
									//console.log(data2);
									$("#div_calib_fact").removeClass('d-none');
									$('#div_calib_fact').html(data3); 
									
								}	
							});	
							
							$('#div_calib_finalcheck').html(""); 
							$.ajax
							({ 
								url: 'aja_show_digmodcalif_finalcheck.php',
								data: "iddib_sn_modulo="+param_sn_modulo+"&idsunit="+param_sn_unit,	
								type: 'post',
								async:true,
								cache:false,
								success: function(data3)
								{
									console.log('a ver--- div_calib_finalcheck');
									$("#div_calib_finalcheck").removeClass('d-none');
									$('#div_calib_finalcheck').html(data3); 
									
								}	
							});
						/////div_scripttime 
							$('#div_scripttime').html(""); 
							$.ajax
							({ 
								url: 'aja_show_digcalif_div_scripttimefinalchk.php',
								data: "iddib_sn_modulo="+param_sn_modulo+"&idsunit="+param_sn_unit,	
								type: 'post',
								async:true,
								cache:false,
								success: function(data3)
								{
									console.log('a ver--- div_scripttime');
									$("#div_scripttime").removeClass('d-none');
									$('#div_scripttime').html(data3); 
									
								}	
							});
						
						
						losbuttons = losbuttons + '<textarea class="form-control" rows="18" id="detallelog" name="detallelog"></textarea>';
						$('#infolog').html(losbuttons); 
						
						
						
					$("#myTabledib").removeClass('d-none');
					$("#myTablecaliffw").removeClass('d-none');
					$("#myTablecalifsn").removeClass('d-none');
					$("#myTablecalifciu").removeClass('d-none');
					$("#myTablecalifciu").removeClass('d-none');
					$("#myTablecaliffreq").removeClass('d-none');
					
				}
			});
			
		}
		
		function mostrar_digmodcalib (param_sn_modulo,param_sn_unit )
		{
			//habilitamos los div de los TAB
				$("#divgeneralinfo").addClass('d-none');
				$("#divgeneralinfoparam").addClass('d-none');
				$("#divdetinfolog").addClass('d-none');
				
				$("#diveq").addClass('d-none');
				$("#divfactory").addClass('d-none');
				$("#divfinalcheck").addClass('d-none');
				$("#divgroupbyciu").addClass('d-none');
				
					$("#divgeneralinfo").removeClass('d-none');
					$("#diveq").removeClass('d-none');
					$("#divfactory").removeClass('d-none');
					$("#divfinalcheck").removeClass('d-none');
					$("#divdetinfolog").removeClass('d-none');
					$("#divscripttime").removeClass('d-none');
						
					$('#infolog').html(""); 
					var losbuttons= "";	
				
			
					$("#myTable").addClass('d-none');
					$("#myTablechanel").addClass('d-none');
					$("#myTableul").addClass('d-none');
					$("#myTablesubband").addClass('d-none');
				
					
					$("#myTabledib").addClass('d-none');
					$("#myTabledibciu").addClass('d-none');
					$("#myTabledibfw").addClass('d-none');
					$("#myTabledibsn").addClass('d-none');
					$("#myTabledibsn").addClass('d-none');
					$("#myTablecaliffw").addClass('d-none');
					$("#myTablecalifsn").addClass('d-none');
					$("#myTablecalifciu").addClass('d-none');
					$("#myTablecaliffreq").addClass('d-none');
					   
					
				
					var myTabledib = $("#myTabledib");
					myTabledib.html("<table id='myTabledib' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'><tr data-rowdib='0'><td data-rowdib='0' data-coldib='0' class='table-info'><b>GENERAL INFO</b> </td></tr><tr data-rowdib='1'><td data-rowdib='1' data-coldib='0'>Date</td></tr><tr data-rowdib='2'><td data-rowdib='2' data-coldib='0'>TotalTime </td></tr><tr data-rowdib='3'><td data-rowdib='3' data-coldib='0'>Calibratior </td></tr><tr data-rowdib='4'><td data-rowdib='4' data-coldib='0'>Station</td></tr><tr data-rowdib='5'><td data-rowdib='5' data-coldib='0'>FAS</td></tr><tr data-rowdib='6'><td data-rowdib='6' data-coldib='0'>Total Pass </td></tr></table>");
					
					var myTablecaliffw = $("#myTablecaliffw");
					myTablecaliffw.html("<table id='myTablecaliffw' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'><tr data-rowcaliffw='0'><td data-rowcaliffw='0' data-colcaliffw='0' class='table-info'><b>FWs</b> </td></tr>	<tr data-rowcaliffw='1'><td data-rowcaliffw='1' data-colcaliffw='0'>FW FPGA</td></tr><tr data-rowcaliffw='2'><td data-rowcaliffw='2' data-colcaliffw='0'>FW uC </td></tr><tr data-rowcaliffw='3'><td data-rowcaliffw='3' data-colcaliffw='0'>FW Rabb </td></tr><tr data-rowcaliffw='4'><td data-rowcaliffw='4' data-colcaliffw='0'>FW PAHP </td></tr></table>");
					
					var myTablecalifsn = $("#myTablecalifsn");
					myTablecalifsn.html("<table id='myTablecalifsn' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none '><tr data-rowcalifsn='0'><td data-rowcalifsn='0' data-colcalifsn='0' class='table-info'><b>SNs</b> </td></tr><tr data-rowcalifsn='1'><td data-rowcalifsn='1' data-colcalifsn='0'>SN DB</td></tr><tr data-rowcalifsn='2'><td data-rowcalifsn='2' data-colcalifsn='0'>SN Unit </td></tr><tr data-rowcalifsn='3'><td data-rowcalifsn='3' data-colcalifsn='0'>SN PALP </td></tr><tr data-rowcalifsn='4'><td data-rowcalifsn='4' data-colcalifsn='0'>SN PAHP </td></tr></table>");
					
					var myTablecalifciu = $("#myTablecalifciu");
					myTablecalifciu.html("<table id='myTablecalifciu' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'><tr data-rowcalifciu='0'><td data-rowcalifciu='0' data-colcalifciu='0' class='table-info'><b>CIUs</b> </td></tr><tr data-rowcalifciu='1'><td data-rowcalifciu='1' data-colcalifciu='0'>CIU DB</td></tr><tr data-rowcalifciu='2'><td data-rowcalifciu='2' data-colcalifciu='0'>CIU Unit </td></tr><tr data-rowcalifciu='3'><td data-rowcalifciu='3' data-colcalifciu='0'>CIU PALP</td></tr><tr data-rowcalifciu='4'><td data-rowcalifciu='4' data-colcalifciu='0'>CIU PAHP </td></tr></table>");
					
					var myTablecaliffreq = $("#myTablecaliffreq");
					myTablecaliffreq.html("<table id='myTablecaliffreq' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped d-none '><tr data-rowccaliffreq='0'><td data-rowcaliffreq='0' data-colcaliffreq='0' class='table-info'><b>Freqs</b> </td></tr><tr data-rowcaliffreq='1'><td data-rowcaliffreq='1' data-colcaliffreq='0'>UL Start</td></tr><tr data-rowcaliffreq='2'><td data-rowcaliffreq='2' data-colcaliffreq='0'>UL Stop </td></tr><tr data-rowcaliffreq='3'><td data-rowcaliffreq='3' data-colcaliffreq='0'>DL Start</td></tr><tr data-rowcaliffreq='4'><td data-rowcaliffreq='4' data-colcaliffreq='0'>DL Stop </td></tr></table>");
					
			$.ajax
			({ 
				url: 'aja_show_digmodcalif.php',
				data: "iddib_sn_modulo="+param_sn_modulo+"&idsunit="+param_sn_unit,	
				type: 'post',
				async:true,
                cache:false,
				success: function(data)
				{
					
					//var datax = JSON.parse(data)
					$('#ciusnshow').html( $('#ciusnshowbks').html() + ' &nbsp; Calib:  '+ param_sn_modulo); 
				    $("#msjwait").hide();
				 	
						$.each(data.gicalif, function(i, itemdib) {
							console.log('muestro CALIB...itemdib:'+itemdib.totalpass);
							AddNewColdl(1,itemdib,'dib');				
						});
					//	myTablecaliffw
						$.each(data.gicaliffw, function(i, itemcaliffw) {
							//console.log('muestro itemdibfw:'+itemdibfw.totalpass);
							AddNewColdl(1,itemcaliffw,'califfw');							
						});
						$.each(data.gicalisn, function(i, itemcalifsn) {
							//console.log('muestro itemdibfw:'+itemdibfw.totalpass);
							AddNewColdl(1,itemcalifsn,'califsn');							
						});
						$.each(data.gicaliciu, function(i, itemcalifciu) {
							//console.log('muestro itemdibfw:'+itemdibfw.totalpass);
							AddNewColdl(1,itemcalifciu,'califciu');							
						});
						$.each(data.gicalifreq, function(i, itemcaliffreq) {
							//console.log('muestro itemdibfw:'+itemdibfw.totalpass);
							AddNewColdl(1,itemcaliffreq,'califfreq');							
						});
						
						
						
						
						
						
						$.each(data.gilogcalif, function(i, itemlog) {
							console.log('muestro  califlog:'+itemlog.idlog);
							losbuttons = losbuttons + '<span class="badge badge-primary" onclick="show_log('+itemlog.idlog+')"><i class="fas fa-search"></i> Log DigMod: ('+itemlog.idlog+') </span> - ';	
													
						});
						
						//List to EQ
					//	console.log("Buscando eq");
						$('#div_calib_eq').html(""); 
							$.ajax
							({ 
								url: 'aja_show_digmodcalif_eq.php',
								data: "iddib_sn_modulo="+param_sn_modulo+"&idsunit="+param_sn_unit,	
								type: 'post',
								async:true,
								cache:false,
								success: function(data2)
								{
									//console.log(data2);
									$("#div_calib_eq").removeClass('d-none');
									$('#div_calib_eq').html(data2); 
									
								}	
							});	
							
							$('#div_calib_fact').html(""); 
							$.ajax
							({ 
								url: 'aja_show_digmodcalif_factory.php',
								data: "iddib_sn_modulo="+param_sn_modulo+"&idsunit="+param_sn_unit,	
								type: 'post',
								async:true,
								cache:false,
								success: function(data3)
								{
									//console.log(data2);
									$("#div_calib_fact").removeClass('d-none');
									$('#div_calib_fact').html(data3); 
									
								}	
							});	
							
							$('#div_calib_finalcheck').html(""); 
							$.ajax
							({ 
								url: 'aja_show_digmodcalif_finalcheckstep0.php',
								data: "iddib_sn_modulo="+param_sn_modulo+"&idsunit="+param_sn_unit,	
								type: 'post',
								async:true,
								cache:false,
								success: function(data3)
								{
									console.log('a ver--- div_calib_finalcheck');
									$("#div_calib_finalcheck").removeClass('d-none');
									$('#div_calib_finalcheck').html(data3); 
									
								}	
							});
						/////div_scripttime 
							$('#div_scripttime').html(""); 
							$.ajax
							({ 
								url: 'aja_show_digmodcalif_div_scripttime.php',
								data: "iddib_sn_modulo="+param_sn_modulo+"&idsunit="+param_sn_unit,	
								type: 'post',
								async:true,
								cache:false,
								success: function(data3)
								{
									console.log('a ver--- div_scripttime');
									$("#div_scripttime").removeClass('d-none');
									$('#div_scripttime').html(data3); 
									
								}	
							});
						
						
						losbuttons = losbuttons + '<textarea class="form-control" rows="18" id="detallelog" name="detallelog"></textarea>';
						$('#infolog').html(losbuttons); 
						
						
						
					$("#myTabledib").removeClass('d-none');
					$("#myTablecaliffw").removeClass('d-none');
					$("#myTablecalifsn").removeClass('d-none');
					$("#myTablecalifciu").removeClass('d-none');
					$("#myTablecalifciu").removeClass('d-none');
					$("#myTablecaliffreq").removeClass('d-none');
					
				}
			});
			
		}
		
		function mostrar_digmod(param_sn_modulo,param_sn_unit ) 
		{
			//console.log("mostrar DIG MOD" +  param_sn_modulo+ '-'+ param_sn_unit );
				$("#divgeneralinfo").addClass('d-none');
				$("#divgeneralinfoparam").addClass('d-none');
				$("#divdetinfolog").addClass('d-none');
				
				$("#diveq").addClass('d-none');
				$("#divfactory").addClass('d-none');
				$("#divfinalcheck").addClass('d-none');
				$("#divgroupbyciu").addClass('d-none');
				
					$("#divgeneralinfo").removeClass('d-none');
					$("#divdetinfolog").removeClass('d-none');
						$("#divfactory").removeClass('d-none');
				$("#divscripttime").removeClass('d-none');
									
			//Ocultamos DIV de Gralinfo
					$("#myTable").addClass('d-none');
					$("#myTablechanel").addClass('d-none');
					$("#myTableul").addClass('d-none');
					$("#myTablesubband").addClass('d-none');
					
					$('#infolog').html(""); 
			
			var myTabledib = $("#myTabledib");
			var myTabledibciu = $("#myTabledibciu");
			var myTabledibfw = $("#myTabledibfw");
			var myTabledibsn = $("#myTabledibsn");
			
			myTabledib.html("<table id='myTabledib' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'><tr data-rowdib='0'><td data-rowdib='0' data-coldib='0' class='table-info'><b>GENERAL INFO</b> </td></tr><tr data-rowdib='1'><td data-rowdib='1' data-coldib='0'>Date</td></tr><tr data-rowdib='2'><td data-rowdib='2' data-coldib='0'>TotalTime </td></tr><tr data-rowdib='3'><td data-rowdib='3' data-coldib='0'>Calibratior </td></tr><tr data-rowdib='4'><td data-rowdib='4' data-coldib='0'>Station</td></tr><tr data-rowdib='5'><td data-rowdib='5' data-coldib='0'>FAS</td></tr><tr data-rowdib='6'><td data-rowdib='6' data-coldib='0'>Total Pass </td></tr></table>");
			myTabledibciu.html("<table id='myTabledibciu' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'><tr data-rowdibciu='0'><td data-rowdibciu='0' data-coldibciu='0' class='table-info'><b>CIUs</b> </td></tr><tr data-rowdibciu='1'><td data-rowdibciu='1' data-coldibciu='0'>CIU DB</td></tr><tr data-rowdibciu='2'><td data-rowdibciu='2' data-coldibciu='0'>CIU Unit </td></tr></table>");
			myTabledibfw.html("<table id='myTabledibfw' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'>				 <tr data-rowdibfw='0'><td data-rowdibfw='0' data-coldibfw='0' class='table-info'><b>FWs</b> </td></tr><tr data-rowdibfw='1'><td data-rowdibfw='1' data-coldibfw='0'>FW FPGA</td></tr><tr data-rowdibfw='2'><td data-rowdibfw='2' data-coldibfw='0'>FW uC </td></tr><tr data-rowdibfw='3'><td data-rowdibfw='3' data-coldibfw='0'>FW Rabb </td></tr></table>");
			myTabledibsn.html("	<table id='myTabledibsn' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none '><tr data-rowdibsn='0'><td data-rowdibsn='0' data-coldibsn='0' class='table-info'><b>SNs</b> </td></tr><tr data-rowdibsn='1'><td data-rowdibsn='1' data-coldibsn='0'>SN DB</td></tr><tr data-rowdibsn='2'><td data-rowdibsn='2' data-coldibsn='0'>SN Unit </td></tr></table>");
			
			
			
			var losbuttons= "";			
							
							
			
			$.ajax
			({ 
				url: 'aja_show_digmod.php',
				data: "iddib_sn_modulo="+param_sn_modulo+"&idsunit="+param_sn_unit,	
				type: 'post',
				async:true,
                cache:false,
				success: function(data)
				{
					//alert(data);
					//var datax = JSON.parse(data)
				    $("#msjwait").hide();
				 	$('#ciusnshow').html( $('#ciusnshowbks').html() + ' &nbsp; DigMod:  '+ param_sn_modulo); 
						$.each(data.gi, function(i, itemdib) {
							//console.log('muestro itemdib:'+itemdib.totalpass);
							AddNewColdl(1,itemdib,'dib');				
						});
						$.each(data.gifw, function(i, itemdibfw) {
							//console.log('muestro itemdibfw:'+itemdibfw.totalpass);
							AddNewColdl(1,itemdibfw,'dibfw');							
						});
						$.each(data.gisn, function(i, itemdibsn) {
							//console.log('muestro itemdibsn:'+itemdibsn.totalpass);
							AddNewColdl(1,itemdibsn,'dibsn');							
						});
						$.each(data.giciu, function(i, itemdibciu) {
							//console.log('muestro itemdibsn:'+itemdibciu.totalpass);
							AddNewColdl(1,itemdibciu,'dibciu');							
						});
						$.each(data.gilog, function(i, itemlog) {
							console.log('muestro log:'+itemlog.idlog);
							losbuttons = losbuttons + '<span class="badge badge-primary" onclick="show_log('+itemlog.idlog+')"><i class="fas fa-search"></i> Log DigMod: ('+itemlog.idlog+') </span> - ';	
													
						});
						
						losbuttons = losbuttons + '<textarea class="form-control" rows="18" id="detallelog" name="detallelog"></textarea>';
						$('#infolog').html(losbuttons); 
						
						
					$("#myTabledib").removeClass('d-none');
					$("#myTabledibciu").removeClass('d-none');
					$("#myTabledibfw").removeClass('d-none');
					$("#myTabledibsn").removeClass('d-none');
				}
			});
			
		}
		
		function Call_calibration(v_ciuparam, v_snparam ,idorderspasad)
		{
			var armando_tabla="";
			//var armando_tabla="<table class='table table-sm table-bordered textotabla10'>";
			//Sumamos Datos de la calibration a la tabla
						 
						
		//	armando_tabla=armando_tabla+"<tr><td colspan=5 class='text-left'><div class='container table-responsive-sm'><table class='table table-sm table-hover  table-bordered text-left texto10 fondoblanco'>";
			//armando_tabla=armando_tabla+"<thead><tr class='thead-dark'><th>Ref:</th><th>Calr:</th><th>Calr Check:</th><th>Status:<br> Gain</th><th>Status:<br>MaxPower</th><th> Status:<br> NF</th><th> Status:<br> IMD</th><th> Status:<br> Spurious</th></tr></thead><tbody>";
			//armando_tabla=armando_tabla+"<tr><td class='text-left'>700 FirstNet <b>[UP]</b></td><td class='text-center'> <button onclick='openpopupframe2(this.value)' class='btn btn-outline-info btn-xs' value="+idsnaver+"><i class='fas fa-search'></i> </button> </td><td class='text-center'><button onclick='openpopupframe2(this.value)' class='btn btn-outline-info btn-xs' value="+idsnaver+"><i class='fas fa-search'></i> </button></td><td><span class='badge badge-pill badge-success'>Passed</span></td><td><span class='badge badge-pill badge-success'>Passed</span></td><td><span class='badge badge-pill badge-danger'>Not Passed</span></td><td><span class='badge badge-pill badge-danger'>Not Passed</span></td><td><span class='badge badge-pill badge-danger'>Not Passed</span></td></tr>";
		
			
								$.ajax({
										url: 'calibrationfinalcheck_jsondesdesaleord.php?idsndib='+v_snparam,										
										 cache:false,
										success: function(respuesta) {
											
											armando_tabla=armando_tabla+respuesta;
											
											armando_tabla=armando_tabla+"</tbody></table>";						
									
						//console.log('abrir div'+idsnaver);
											$('#generalinfocalib').html(""+armando_tabla);
										},
										error: function() {
											console.log("No se ha podido obtener la información");
											$('#generalinfocalib').html("");
										}
									});
		}
		
		function Call_create_RMA(v_ciuparam, v_snparam ,idorderspasad)
		{
			
			
			Swal.fire({
title:'Create RMA',			
					input: 'text',
					html: 'CIU: '+v_ciuparam+' - SN:'+ v_snparam +'<br>  Assign SO RMA:',	
					  inputPlaceholder: 'Enter your RMA Number SO',
  inputAttributes: {
    autocapitalize: 'off'
  },
  showCancelButton: true,
  confirmButtonText: 'Create',
  showLoaderOnConfirm: true,
  preConfirm: (login) => {
	 // alert(login);
	  if (login =='')
	  {
		 Swal.showValidationMessage('Please, Enter RMA Number SO');
        
	  }
	  else
	  {
		  allowOutsideClick: () => !Swal.isLoading()
	 
		return fetch('aja_creatermapost.php?v0='+v_snparam+'&v1='+v_ciuparam+'&v2='+idorderspasad+'&v3='+login)
      .then(response => {
        if (!response.ok) {
          throw new Error(response.statusText)
        }
        return response.json()
      })
      .catch(error => {
        Swal.showValidationMessage(
          `Request failed: ${error}`
        )
      })
	   }
	  
  },
 // allowOutsideClick: () => !Swal.isLoading()
}).then((result) => {
	
  if (result.value.result=="ok") {
  /*  Swal.fire({
      title: `${result.value.result}'`,
      imageUrl: result.value.avatar_url
    })*/
	Swal.fire({
							  title: 'RMA Saved!',							  
							  icon: 'success',
							  showCancelButton: false,
							  confirmButtonColor: '#3085d6',							  
							  confirmButtonText: 'OK',							  
							}).then((result) => {
							  if (result.value) 
							  {
								window.location="saleorders.php"; 
							  }
							  else
							  {
								 window.location="saleorders.php";
							  }
							})
  }
  else
  {
	  alert('Error');
  }
})
			/*
			const { value: email } =  await Swal.fire({
				 	title:'Create RMA',			
					input: 'text',
					html: 'CIU: '+v_ciuparam+' - SN:'+ v_snparam +'<br>  Assign SO RMA:',	
				  inputPlaceholder: 'Enter your RMA Number SO'
				})
			
				if (email) {
					alert('a' + email) ;
				  Swal.fire(`Entered email: ${email}`)
				}
				else
				{
				alert('b' + email) ;	
				}
				*/

/*
			const ipAPI = '//api.ipify.org?format=json'
			
			

			Swal.queue([{
				title:'Create RMA',			
				input: 'text',
				html: 'CIU: '+v_ciuparam+' - SN:'+ v_snparam +'<br>  Assign SO RMA:',				    
			  confirmButtonText: 'Create RMA',			 
			  showLoaderOnConfirm: true,
			  showCancelButton: true,			  
			  preConfirm: () => {
				return fetch(ipAPI)
				  .then(response => response.json())
				  .then(data => Swal.insertQueueStep(data.ip))
				  .catch(() => {
					Swal.insertQueueStep({
					  icon: 'error',
					  title: 'Unable to get your public IP'
					})
				  })
			  }
			}])
			*/
			
		}
		
	function show_po_So_Edit(vidpo, idshow, vsn)
	{
		
		
		$('div.pre-scrollablemarco').removeClass("active");
		$('div.pre-scrollablemarco').removeClass("active");
		$('a.nav-link').removeClass("active");
		$("#div_diveditparamciu").removeClass('d-none');
		$("#diveditparamciu").addClass('active');
		$("#div_diveditparamciu").addClass('active');
		$('#editciusn').addClass('active');
		
		
		
			 tabla_cui_cant = [];
			tabla_channel_quantity = [];
			tabla_gain_dlul= [];
			tabla_dpx =[];
			$("#lossnamodif").val('');
		   
		//console.log('aaaa' + vidpo + '+++++' + idshow);
			$('#msjwaitline ').show();
			toastr.options = {
						  "closeButton": false,
						  "debug": false,
						  "newestOnTop": false,
						  "progressBar": true,
						  "positionClass": "toast-bottom-right",
						  "preventDuplicates": false,
						  "onclick": null,
						  "showDuration": "600",
						  "hideDuration": "1000",
						  "timeOut": "5000",
						  "extendedTimeOut": "1000",
						  "showEasing": "swing",
						  "hideEasing": "linear",
						  "showMethod": "fadeIn",
						  "hideMethod": "fadeOut"
						};
				
			toastr["success"]("Wait....Search Results", "Attention :: SO List");
			var tabla_info_show_po = "";
			var v_rcgfbwa ="";
			var v_moden_dig ="";
			var cantrequired =0;
		 $.ajax
			({ 
				url: 'readsoinfo.php',
				data: "idpo="+vidpo+"&sn="+vsn,	
				type: 'post',				
				datatype:'JSON',                
				success: function(data)
				{
					
				///alert(data);
					
					 $("#msjwaitline").hide();
					 
					 //show data po y rebv
					  $("#podatos").html(' '+ data.ps[0].ponumber+' Rev:'+data.ps[0].idrev+'<br><br>');
					  $("#podatos").removeClass('d-none');
					 tabla_info_show_po="<table class='table table-striped '><tbody><tr><td> <b>CIU: </b></td><td>"+data.ps[0].ciu+"</td><td> <b>Quantity: </b></td><td>"+data.ps[0].quantity+"</td></tr>";
					 
					 
					  $.each(data.lossn, function(i, item_lossn) 
					  {
						  console.log(i +'----' +item_lossn.elsn);
						 ///  $("#lossnamodif").val( $("#lossnamodif").val()+ '#'+ item_lossn.elsn);
					  }); 
					 
					
					
					 $("#txtsoexternal").val(data.ps[0].so_soft_external);
					 
					  cantrequired = data.ps[0].quantity;
					 $("#poselecm").val(data.ps[0].idpresales);
					 $("#poselecmrev").val(data.ps[0].idrev);
					
					 $("#txtdescripso").val(data.ps[0].descripcion);
					 $("#txtnotepo").val(data.ps[0].notes);
					  tabla_info_show_po=tabla_info_show_po+"<tr><th>Description PO:<br></th><td colspan=3>"+data.ps[0].descripcion+"</td></tr>";	
					  tabla_info_show_po=tabla_info_show_po+"<tr><th>Notes PO:<br></th><td colspan=3>"+data.ps[0].notes+"</td></tr>";	
					
					 if( data.ps[0].rcgfbwa == true)
					 {
						  $('#txtrcgbwa').bootstrapToggle('on');
						  $('#txtrcgbwa').attr('checked', true);  
						  
						
						  
						v_rcgfbwa =" <span class='btn btn-outline-success btn-xs'>Yes</span>"
					 }
					 else
					 {
						  $('#txtrcgbwa').bootstrapToggle('off');
						  $('#txtrcgbwa').attr('checked', false);  
						 v_rcgfbwa= " <span class='btn btn-outline-danger btn-xs'>No</span>"
					 }
					  if( data.ps[0].moden_dig == true)
					 {
						  $('#txtmoden').bootstrapToggle('on');
						v_moden_dig =" <span class='btn btn-outline-success btn-xs'>Yes</span>"
					 }
					 else
					 {
						  $('#txtmoden').bootstrapToggle('off');
						 v_moden_dig= " <span class='btn btn-outline-danger btn-xs'>No</span>"
					 }
					 
					  $("#txtdlgain").val(data.ps[0].dl_gain);
					   $("#txtdlmaxpwr").val(data.ps[0].dl_max_pwr);
					    $("#txtulgain").val(data.ps[0].ul_gain);
						 $("#txtulmaxpwr").val(data.ps[0].ul_max_pwr);
						 if (data.ps[0].pwrsupplytype =="AC/DC")
						 {
							document.getElementById("txtpwrsupply").selectedIndex =1; 
						 }
						 else
						 {
							 document.getElementById("txtpwrsupply").selectedIndex =2;
						 }
							
					 tabla_info_show_po=tabla_info_show_po+"<tr><td><b>POWER SUPPLY TYPE:</b></td><td>"+data.ps[0].pwrsupplytype+"</td><td></td><td></td></tr>"
					 tabla_info_show_po=tabla_info_show_po+"<tr><td><b>RC-G for BWA:</b></td><td>"+v_rcgfbwa+"</td><td><b>Moden for Digital:</b></td><td>"+v_moden_dig+" </td></tr>";
					 tabla_info_show_po=tabla_info_show_po+"<tr><td><b>DL gain: </b></td><td>"+data.ps[0].dl_gain+" (dB)</td><td><b>UL  gain:</b></td> <td>"+data.ps[0].ul_gain+" (dB)</td></tr>";
					 tabla_info_show_po=tabla_info_show_po+"<tr><td><b>DL Max Pwr Out: </b></td><td>"+data.ps[0].dl_max_pwr+" (dBm)</td><td><b>UL 	Max Pwr Out:</b></td> <td>"+data.ps[0].ul_max_pwr+"  (dBm)</td></tr>";
					 
					 tabla_info_show_po=tabla_info_show_po+"<tr><td><br></td><td></td><td></td><td></td></tr>";		
					 tabla_info_show_po=tabla_info_show_po+"<tr><th><b>UNIT (DL - UL) List</b></th><td></td><td></td><td></td></tr>";		
					 var note_unit = "";
					 $.each(data.psunit, function(i, itempsunit) {
							note_unit = itempsunit.notes;
								tabla_info_show_po=tabla_info_show_po+"<tr><td>Unit DL: Start: <b>"+itempsunit.unitdlstart+"</b> MHz</td><td>Unit DL: Stop: <b>"+itempsunit.unitdlstop+"</b> MHz</td><td>Unit UL: Start: <b>"+itempsunit.unitulstart+"</b> MHz</td> <td>Unit UL: Stop: <b>"+itempsunit.unitulstop+"</b> MHz</td></tr>";		
								
								tabla_gain_dlul.push({						
									gainudstart: parseFloat(itempsunit.unitdlstart),
									gainudstop: parseFloat(itempsunit.unitdlstop),
									gainulstart: parseFloat(itempsunit.unitulstart),
									gainulstop: parseFloat(itempsunit.unitulstop)
						   });
						   
						});
						
						   
						   tabla_gain_udul();
						
							  tabla_info_show_po=tabla_info_show_po+"<tr><th>Note Unit:<br></th><td colspan=3>"+note_unit+"</td></tr>";	
						
					 
					  tabla_info_show_po=tabla_info_show_po+"<tr><th><br></th><td></td><td><br></td><td></td></tr>";		
					 tabla_info_show_po=tabla_info_show_po+"<tr><th><b>DPX (Low - High) List</b></th><td></td><td></td><td></td></tr>";		
					 $.each(data.psdpx, function(i, itempsdpx) {
							
								tabla_info_show_po=tabla_info_show_po+"<tr><td>DPX Low Start: <b>"+itempsdpx.dpxlowstart+"</b> MHz</td><td>DPX Low Stop: <b>"+itempsdpx.dpxlowstop+"</b> MHz</td><td>DPX High Start: <b>"+itempsdpx.dpxhihgstart+"</b> MHz</td> <td>DPX High Stop: <b>"+itempsdpx.dpxhihgstop+"</b> MHz</td></tr>";		
								
								 tabla_dpx.push({						
									dpxlowstart: parseFloat(itempsdpx.dpxlowstart),
									dpxlowstop:  parseFloat(itempsdpx.dpxlowstop),
									dpxhighstart: parseFloat(itempsdpx.dpxhihgstart),
									dpxhighstop: parseFloat(itempsdpx.dpxhihgstop)
						   });
						   
						});
					 list_tabla_dpx();
					 tabla_info_show_po=tabla_info_show_po+"<tr><th><br></th><td></td><td><br></td><td></td></tr>";		
					 tabla_info_show_po=tabla_info_show_po+"<tr><th><b>Channels List</b></th><td></td><td></td><td></td></tr>";		
					 var note_unit_ch="";
					 $.each(data.psch, function(i, itempsch) {
							console.log(i +'muestro psch...itemdib:'+itempsch.totalpass);
								note_unit_ch = itempsch.notes;
								tabla_info_show_po=tabla_info_show_po+"<tr><td><b>DL Channels :</b></td><td><b>"+itempsch.dl_ch_fr+"</b> (MHz)</td><td><b>UL Channels :</b></td> <td><b>"+itempsch.ul_ch_fr+"</b> (MHz)</td></tr>";		
								
								 tabla_channel_quantity.push({						
							channeldl: parseFloat(itempsch.dl_ch_fr),
							channelul: parseFloat(itempsch.ul_ch_fr)						
							});
							
						});
						
						 
							tabla_channels();
						
						tabla_info_show_po=tabla_info_show_po+"<tr><th>Note Channels:<br></th><td colspan=3>"+note_unit_ch+"</td></tr>";	
						
						$("#txtnotechanel").val(note_unit_ch);
					tabla_info_show_po=tabla_info_show_po+"<tr><th><br></th><td></td><td><br></td></tr>";	

					

					if( data.ps[0].req_ppassy == true)
					 {
						 $('#txtppassy').bootstrapToggle('on');
						 $('#txtppassy_abert').bootstrapToggle('on');
						 
						v_req_ppassyg =" <span class='btn btn-outline-success btn-xs'>Yes</span>"
					 }
					 else
					 {
						  $('#txtppassy').bootstrapToggle('off');
						   $('#txtppassy_abert').bootstrapToggle('off');
						 v_req_ppassyg= " <span class='btn btn-outline-danger btn-xs'>No</span>"
					 }
					  if( data.ps[0].req_calibration == true)
					 {
						  $('#txtreqcalib').bootstrapToggle('on');
						  $('#txtreqcalib_abert').bootstrapToggle('on');
						v_req_calibration =" <span class='btn btn-outline-success btn-xs'>Yes</span>"
					 }
					 else
					 {
						 $('#txtreqcalib').bootstrapToggle('off');
						 $('#txtreqcalib_abert').bootstrapToggle('off');
						 v_req_calibration= " <span class='btn btn-outline-danger btn-xs'>No</span>"
					 }
					   if( data.ps[0].req_spec == true)
					 {
						  $('#txtmatespecial').bootstrapToggle('on');
						  $('#txtmatespecial_abert').bootstrapToggle('on');
						v_req_spec =" <span class='btn btn-outline-success btn-xs'>Yes</span>"
					 }
					 else
					 {
						  $('#txtmatespecial').bootstrapToggle('off');
						  $('#txtmatespecial_abert').bootstrapToggle('off');
						 v_req_spec= " <span class='btn btn-outline-danger btn-xs'>No</span>"
					 }
					   if( data.ps[0].req_other == true)
					 {
						  $('#txtotherchange').bootstrapToggle('on');
						  $('#txtotherchange_abert').bootstrapToggle('on');
						v_req_other =" <span class='btn btn-outline-success btn-xs'>Yes</span>"
					 }
					 else
					 {
						  $('#txtotherchange').bootstrapToggle('off');
						  $('#txtotherchange_abert').bootstrapToggle('off');
						 v_req_other= " <span class='btn btn-outline-danger btn-xs'>No</span>"
					 }
					  $("#txtdescripmatesp").val(data.ps[0].reqresources);
					  $("#txtdescripmatesp_abert").val(data.ps[0].reqresources);
					tabla_info_show_po=tabla_info_show_po+"<tr><td><b>Training required for PP-ASSY: </b></td><td>"+v_req_ppassyg+"</td><td><b>Training required for Calibration:</b></td> <td>"+v_req_calibration+" </td></tr>";		
					tabla_info_show_po=tabla_info_show_po+"<tr><td><b>Special Material required: </b></td><td>"+v_req_spec+"</td><td><b>Other:</b></td> <td>"+v_req_other+" </td></tr>";		
					tabla_info_show_po=tabla_info_show_po+"<tr><th>Description of Resources Required::<br></th><td colspan=3>"+data.ps[0].reqresources+"</td></tr>";	
					 tabla_info_show_po=tabla_info_show_po+"</tbody></table>";
									 
					 
					
					 $("#txtsoluumber").val(data.ps[0].so_soft_external);
					 
					 var element =  document.getElementById('btnchangep');
								if (typeof(element) != 'undefined' && element != null)
								{
								  // Exists.
								   document.getElementById("btnchangep").disabled = false;		
								}
								
								var element =  document.getElementById('btnchangep_abert');
								if (typeof(element) != 'undefined' && element != null)
								{
								  // Exists.
								   document.getElementById("btnchangep_abert").disabled = false;		
								}
					 
				
					  
					   document.getElementById("txtlistcius").value = data.ps[0].idproduct;
					    	$('#txtciushow').html(data.ps[0].ciu);
					   
					   
					  
					  
						$('#generalinfopo').html(tabla_info_show_po);
						
						/// vamos a mostrarr los CUI con STOCK
						tabla_info_stock="";
							tabla_info_stock=tabla_info_stock+"<table class='table table-striped '><tbody><tr><td colspan=4> <b> Stock CIU: </b></td></tr>";
							tabla_info_stock=tabla_info_stock+"<tr><td colspan='2'><input type='hidden' name='quiengenerarlossn' id='quiengenerarlossn' value=''><button type='button' class='btn btn-block btn-outline-primary' onclick='seleciongenerasn(1)' name='btnsn1' id='btnsn1'>Assign SN FasServer</button>  </td><td colspan='2'> <button type='button' class='btn btn-block btn-outline-success' onclick='seleciongenerasn(2)' name='btnsn2' id='btnsn2'>Assign SN User</button> </td></tr>";

						var idproducttemp=0;
						var autoselectsn =1;
						var ischequed = "";
						 $.each(data.ciustockdet, function(i, itemstock) {							
								
								
								
							
										if (idproducttemp !=itemstock.idproduct)	
										{
											if (idproducttemp !=0)
											{
												tabla_info_stock=tabla_info_stock+"</td><tr>";
											}
											idproducttemp =itemstock.idproduct;
											tabla_info_stock=tabla_info_stock+"<tr><td>CIU:<b> "+itemstock.modelciu+"</b> </td><td colspan=3>";
											if ( eval(cantrequired) >= autoselectsn )
											{
												ischequed ="checked";
												console.log('a');
												autoselectsn= autoselectsn+ 1 ;
											}
											else
											{
												ischequed ="";
											}
											tabla_info_stock=tabla_info_stock+"<input  type='checkbox' class='combomarco' onclick='sumarme_asign_sn()' value='"+itemstock.wo_serialnumber+"|"+itemstock.so_soft_external+"' id='chkstock"+itemstock.wo_serialnumber+"' name='chkstock"+itemstock.wo_serialnumber+"' "+ischequed+" >"+itemstock.wo_serialnumber+"<br>";											
										}	
										else
										{
											
												if ( eval(cantrequired) >= autoselectsn )
											{
												ischequed ="checked";
												console.log('b'+autoselectsn);
												autoselectsn= autoselectsn+ 1 ;
											}
											else
											{
												ischequed ="";
											}
											tabla_info_stock=tabla_info_stock+"<input  type='checkbox' class='combomarco' onclick='sumarme_asign_sn()' value='"+itemstock.wo_serialnumber+"|"+itemstock.so_soft_external+"' id='chkstock"+itemstock.wo_serialnumber+"' name='chkstock"+itemstock.wo_serialnumber+"' "+ischequed+" >"+itemstock.wo_serialnumber+"<br>";											
										}
										
										
									
								//<option value='1'> 1</option><option value='2'> 2</option><option value='3'> 3</option><option value='4'> 4</option><option value='5'> 5</option>
								
							
												
							});
								tabla_info_stock=tabla_info_stock+"</td></tr>";		
							tabla_info_stock=tabla_info_stock+"<tr><td colspan='4'> </td></tr>";

								//// solo para mostrar el correcto.
							autoselectsn = autoselectsn-1;
				
							var varpermiso_assing_sn = '<?php echo $permiso_assing_sn;?>';							
							if (varpermiso_assing_sn =='Y')
							{
								//// pregunta si tiene asignado SALEORDES
								if (data.ps[0].so_soft_external=='')
								{
									tabla_info_stock=tabla_info_stock+"<tr><td><b>Quantity Required: "+cantrequired+"</b> <input type='hidden' value='"+cantrequired+"' name='vhcantrequerida' id='vhcantrequerida'> </td><td><b>Selected quantity: <input type='hidden'  id='vhcantselect' name='vhcantselect' value="+autoselectsn+"> <span id='cantselect'>"+autoselectsn+"</span></b></td> <td colspan='2'><button type='button' class='btn btn-primary btn-block' id='btnchangep_chirs' disabled name='btnchangep_chirs'>Assign SN</button></td></tr>";		
								}
								else
								{
									tabla_info_stock=tabla_info_stock+"<tr><td><b>Quantity Required: "+cantrequired+"</b> <input type='hidden' value='"+cantrequired+"' name='vhcantrequerida' id='vhcantrequerida'></td><td><b>Selected quantity: <input type='hidden'  id='vhcantselect' name='vhcantselect' value="+autoselectsn+"> <span id='cantselect'>"+autoselectsn+"</span></b></td> <td colspan='2'><button type='button' class='btn btn-primary btn-block' id='btnchangep_chirs' onclick='savechristian()' name='btnchangep_chirs'>Assign SN</button></td></tr>";										
								}
								
							}
							else
							{
							tabla_info_stock=tabla_info_stock+"<tr><td><b>Quantity Required: "+cantrequired+"</b> <input type='hidden' value='"+cantrequired+"' name='vhcantrequerida' id='vhcantrequerida'> </td><td><b>Selected quantity: <input type='hidden'  id='vhcantselect' name='vhcantselect' value="+autoselectsn+"> <span id='cantselect'>"+autoselectsn+"0</span></b></td> <td colspan='2'><button type='button' class='btn btn-primary btn-block' id='btnchangep_chirs' disabled name='btnchangep_chirs'>Assign SN</button></td></tr>";		
							}
							
						
						tabla_info_stock=tabla_info_stock +"</table>";
						tabla_info_stock=tabla_info_stock +"<div class='info-box'><span class='info-box-icon bg-yellow '><i class='fas fa-cogs'></i></span><div class='info-box-content'><a href='generawororder.php'><span class='info-box-number'>Create New Work Orders  </span></a></div></div>";
						  
						//	$('#cuiparachir').html(tabla_info_stock);
									
						
					
					
				}
			});
		
	}
   
   	function list_tabla_dpx()
	{
	var jname ="";
		var v_temp_dpx="";
			var html = 'DPX (Low - High) List <br><table class="table  table-striped table-sm ">';
				 html += '<tr>';
				 var cantcabez = tabla_dpx[0];
				 
				 for( var j in  cantcabez) {						 
					 jname= j
					 if (j=='dpxlowstart')
					 {
						 jname='DPX Low Start';
					 }
					 if (j=='dpxlowstop')
					 {
						 jname='DPX Low Stop';
					 }
					 if (j=='dpxhighstart')
					 {
						 jname='DPX High Start';
					 }
					 if (j=='dpxhighstop')
					 {
						 jname='DPX High Stop';
					 }
					
					 
				  html += '<th>' + jname + '</th>';
				
				 }
				  html += '<th>Action</th>';
				 html += '</tr>';
				 for( var i = 0; i < tabla_dpx.length; i++) {
				  html += '<tr>';
				  
				  if (v_temp_dpx != '')
				  {
					v_temp_dpx = v_temp_dpx + "#";  
				  }
				  
				  for( var j in tabla_dpx[i] ) {
					 
						html += '<td>' + tabla_dpx[i][j]  +' MHz</td>';	  
						v_temp_dpx = v_temp_dpx  + tabla_dpx[i][j] + "|"
					
					
				  }
				  html += '<td>  <a href="#" onclick="borrar_array_dpx('+i+')"> <i class="fas fa-trash-alt"></i> Del</a> </td>';	  
				  html += '</tr>';
				 }
				 html += '</table>';
				 v_temp_dpx = v_temp_dpx + "#";  
				 console.log(v_temp_dpx);
				 	$('#listadpx').html(html);
					$('#templistadpx').val(v_temp_dpx);
	}
	
	function tabla_gain_udul()
	{
		var jname ="";
		var v_templistchannel="";
			var html = '<table class="table  table-striped table-sm ">';
				 html += '<tr>';
				 var cantcabez = tabla_gain_dlul[0];
				 
				 for( var j in  cantcabez) {
					 
					 jname= j
					 if (j=='gainudstart')
					 {
						 jname='DL Start';
					 }
					 if (j=='gainudstop')
					 {
						 jname='DL Stop';
					 }
					 if (j=='gainulstart')
					 {
						 jname='UL Start';
					 }
					 if (j=='gainulstop')
					 {
						 jname='UL Stop';
					 }
					
					 
				  html += '<th>' + jname + '</th>';
				
				 }
				  html += '<th>Action</th>';
				 html += '</tr>';
				 for( var i = 0; i < tabla_gain_dlul.length; i++) {
				  html += '<tr>';
				  
				  if (v_templistchannel != '')
				  {
					v_templistchannel = v_templistchannel + "#";  
				  }
				  
				  for( var j in tabla_gain_dlul[i] ) {
					 
						html += '<td>' + tabla_gain_dlul[i][j]  +' MHz</td>';	  
						v_templistchannel = v_templistchannel  + tabla_gain_dlul[i][j] + "|"
					
					
				  }
				  html += '<td>  <a href="#" onclick="borrar_array_uldl('+i+')"> <i class="fas fa-trash-alt"></i> Del</a> </td>';	  
				  html += '</tr>';
				 }
				 html += '</table>';
				 v_templistchannel = v_templistchannel + "#";  
				 console.log(v_templistchannel);
				 	$('#listagainuldl').html(html);
					$('#templistagainuldl').val(v_templistchannel);
				
		
	}
  
  function tabla_channels()
	{
		var jname ="";
		var v_templistchannel="";
			var html = '<table class="table  table-striped table-sm ">';
				 html += '<tr>';
				 var cantcabez = tabla_channel_quantity[0];
				 
				 for( var j in  cantcabez) {
					 
					 jname= j
					 if (j =='channeldl')
					 {
						 jname="DL Channels (MHz)";
					 }
					  if (j =='channelul')
					 {
						 jname="UL Channels (MHz)";
					 }
					 
				  html += '<th>' + jname + '</th>';
				
				 }
				  html += '<th>Action</th>';
				 html += '</tr>';
				 for( var i = 0; i < tabla_channel_quantity.length; i++) {
				  html += '<tr>';
				  
				  if (v_templistchannel != '')
				  {
					v_templistchannel = v_templistchannel + "#";  
				  }
				  
				  for( var j in tabla_channel_quantity[i] ) {
					 
						html += '<td>' + tabla_channel_quantity[i][j]  +'  MHz</td>';	  
						v_templistchannel = v_templistchannel  + tabla_channel_quantity[i][j] + "|"
					
					
				  }
				  html += '<td>  <a href="#" onclick="borrar_array_channel('+i+')"> <i class="fas fa-trash-alt"></i> Del</a> </td>';	  
				  html += '</tr>';
				 }
				 html += '</table>';
				 v_templistchannel = v_templistchannel + "#";  
				 console.log(v_templistchannel);
				 	$('#listachannel').html(html);
					$('#templistchannel').val(v_templistchannel);
		
	}
	
			
	function add_list_dpx()
	{
		var v_txtdpxlowstart = parseFloat($('#txtdpxlowstart').val());
		var v_txtdpxlowstop = parseFloat($('#txtdpxlowstop').val());
		var v_txtdpxhighstart = parseFloat($('#txtdpxhighstart').val());
		var v_txtdpxhighstop = parseFloat($('#txtdpxhighstop').val());
		
		 if (v_txtdpxlowstart=="" || v_txtdpxlowstop=="" || v_txtdpxhighstart=="" || v_txtdpxhighstop=="" || isNaN(v_txtdpxlowstart)==true || isNaN(v_txtdpxlowstop)==true || isNaN(v_txtdpxhighstart)==true || isNaN(v_txtdpxhighstop)==true )
		  {
				
		  }
		  else
		  {
			  // Agredo los 4 al Array.
			  
			   var v_loencontre_ch = 0;				
					 $.each(tabla_dpx, function (i, value) {
						if (value.dpxlowstart == v_txtdpxlowstart)
						{
							// Lo encontre actualizo datos.
							v_loencontre_ch = 1;							
						}
						if (value.dpxlowstop == v_txtdpxlowstop)
						{
							// Lo encontre actualizo datos.
							v_loencontre_ch = 1;						
						}
						if (value.dpxhighstart == v_txtdpxhighstart)
						{
							// Lo encontre actualizo datos.
							v_loencontre_ch = 1;						
						}
						if (value.dpxhighstop == v_txtdpxhighstop)
						{
							// Lo encontre actualizo datos.
							v_loencontre_ch = 1;						
						}
					
					}); 
					if ( v_loencontre_ch == 0)
					{
						
						   tabla_dpx.push({						
									dpxlowstart: parseFloat(v_txtdpxlowstart),
									dpxlowstop:  parseFloat(v_txtdpxlowstop),
									dpxhighstart: parseFloat(v_txtdpxhighstart),
									dpxhighstop: parseFloat(v_txtdpxhighstop)
						   });
						   list_tabla_dpx();
						   
						    
							$('#txtdpxlowstart').val('');
							$('#txtdpxlowstop').val('');
							$('#txtdpxhighstart').val('');
							$('#txtdpxhighstop').val('');
							
								 $("#txtdpxlowstart").focus();
							  $("#txtdpxlowstart").focus();
					}
			  
		  }
	}
	
	function add_channels()
	{
		//tabla_channel_quantity
		var v_dl_channel = parseFloat($('#txtchud').val());
		var v_ul_channel = parseFloat($('#txtchul').val());
		
		if (v_dl_channel=="" || v_ul_channel =="" || isNaN(v_dl_channel)==true || isNaN(v_ul_channel)==true )
		  {
			  ///|| v_ul_channel ==""
				 var v_loencontre_ch = 0;
		  }
		  else
		  {
			  
			 var v_loencontre_ch = 0;
					
				
					 $.each(tabla_channel_quantity, function (i, value) {
						if (value.channeldl == v_dl_channel)
						{
							// Lo encontre actualizo datos.
							v_loencontre_ch = 1;							
						}
						if (value.channelul == v_ul_channel)
						{
							// Lo encontre actualizo datos.
							v_loencontre_ch = 1;						
						}
					
					}); 
					if ( v_loencontre_ch == 0)
					{
						  tabla_channel_quantity.push({						
							channeldl: parseFloat(v_dl_channel),
							channelul: parseFloat(v_ul_channel)						
							});
							tabla_channels();
							
							 
							$('#txtchud').val('');
							$('#txtchul').val('');
							 $("#txtchud").focus();
							  $("#txtchud").focus();
							
					}
		  }	 
	}
	
	function add_list_gain()
	{
		var v_txtchudstart = parseFloat($('#txtchudstart').val());
		var v_txtchudstop = parseFloat($('#txtchudstop').val());
		var v_txtchulstart = parseFloat($('#txtchulstart').val());
		var v_txtchulstop = parseFloat($('#txtchulstop').val());
		
		 if (v_txtchudstart=="" || v_txtchudstop=="" || v_txtchulstart=="" || v_txtchulstop=="" || isNaN(v_txtchudstart)==true  || isNaN(v_txtchudstop)==true  || isNaN(v_txtchulstart)==true  || isNaN(v_txtchulstop)==true   )
		  {
				
		  }
		  else
		  {
			  // Agredo los 4 al Array.
			  
			   var v_loencontre_ch = 0;				
					 $.each(tabla_gain_dlul, function (i, value) {
						if (value.gainudstart == v_txtchudstart)
						{
							// Lo encontre actualizo datos.
							v_loencontre_ch = 1;							
						}
						if (value.gainudstop == v_txtchudstop)
						{
							// Lo encontre actualizo datos.
							v_loencontre_ch = 1;						
						}
						if (value.gainulstart == v_txtchulstart)
						{
							// Lo encontre actualizo datos.
							v_loencontre_ch = 1;						
						}
						if (value.gainulstop == v_txtchulstop)
						{
							// Lo encontre actualizo datos.
							v_loencontre_ch = 1;						
						}
					
					}); 
					if ( v_loencontre_ch == 0)
					{
						
						   tabla_gain_dlul.push({						
									gainudstart: parseFloat(v_txtchudstart),
									gainudstop: parseFloat(v_txtchudstop),
									gainulstart: parseFloat(v_txtchulstart),
									gainulstop: parseFloat(v_txtchulstop)
						   });
						   tabla_gain_udul();
						   
						   /// Limpia variables
						   
							$('#txtchudstart').val('');
							$('#txtchudstop').val('');
							$('#txtchulstop').val('');
							$('#txtchulstart').val('');
								 $("#txtchudstart").focus();
							  $("#txtchudstart").focus();
							
							
		
					}
			  
		  }
		
	}
   
 /* requesting data */
	 function borrar_array_channel(idborrarch)
	 {
		    tabla_channel_quantity.splice(idborrarch, 1); 
			
			$('body,html').stop(true,true).animate({				
				scrollTop: $("#listachannel").offset().top
			},1);
			
			tabla_channels();
			$('body,html').stop(true,true).animate({				
				scrollTop: $("#listachannel").offset().top
			},1);
	 }
	 
	 function borrar_array_uldl	 (idborrarch)
	 {
		    tabla_gain_dlul.splice(idborrarch, 1); 
			
			$('body,html').stop(true,true).animate({				
				scrollTop: $("#listagainuldl").offset().top
			},1);
			
			tabla_gain_udul();
			$('body,html').stop(true,true).animate({				
				scrollTop: $("#listagainuldl").offset().top
			},1);
	 }
	 
	  function borrar_array_dpx	 (idborrarch)
	 {
		   // tabla_gain_dlul.splice(idborrarch, 1); 
			tabla_dpx.splice(idborrarch, 1); 
			
			$('body,html').stop(true,true).animate({				
				scrollTop: $("#listadpx").offset().top
			},1);
			
			
			list_tabla_dpx();
			$('body,html').stop(true,true).animate({				
				scrollTop: $("#listadpx").offset().top
			},1);
	 }
	 
	 function borrar_array(idborrar)
	 	{
		 
		   tabla_cui_cant.splice(idborrar, 1); 
		 
		 	var html = '<table class="table  table-striped table-sm ">';
				 html += '<tr>';
				 var cantcabez = tabla_cui_cant[0];
				 for( var j in  cantcabez) {
				  html += '<th>' + j + '</th>';
				  if (j==='cant')
				  {
					    html += '<th>Action</th>';
					  break;
				  }
				 }
				 html += '</tr>';
				 for( var i = 0; i < tabla_cui_cant.length; i++) {
				  html += '<tr>';
				  for( var j in tabla_cui_cant[i] ) {
					  if ('idcui' != j)
					  {
						html += '<td>' + tabla_cui_cant[i][j]  +'</td>';	  
					  }
					
				  }
				  html += '<td>  <a href="#" onclick="borrar_array('+i+')"> <i class="fas fa-trash-alt"></i> Del</a> </td>';	  
				  html += '</tr>';
				 }
				 html += '</table>';
				 
			//	 console.log(html);
				 	$('#listacium').html(html);
		 
		}
	 
	 function borrar_array(idborrar)
	 	{
		 
		   tabla_cui_cant.splice(idborrar, 1); 
		 
		 	var html = '<table class="table  table-striped table-sm ">';
				 html += '<tr>';
				 var cantcabez = tabla_cui_cant[0];
				 for( var j in  cantcabez) {
				  html += '<th>' + j + '</th>';
				  if (j==='cant')
				  {
					    html += '<th>Action</th>';
					  break;
				  }
				 }
				 html += '</tr>';
				 for( var i = 0; i < tabla_cui_cant.length; i++) {
				  html += '<tr>';
				  for( var j in tabla_cui_cant[i] ) {
					  if ('idcui' != j)
					  {
						html += '<td>' + tabla_cui_cant[i][j]  +'</td>';	  
					  }
					
				  }
				  html += '<td>  <a href="#" onclick="borrar_array('+i+')"> <i class="fas fa-trash-alt"></i> Del</a> </td>';	  
				  html += '</tr>';
				 }
				 html += '</table>';
				 
				 console.log(html);
				 	$('#listacium').html(html);
		 
		}
		
		
	function openpopupframe(snmodulo, snunit)
	{
			var ipservidorapache= '<?php echo $ipservidorapache; ?>';	
			//alert(ipservidorapache);
		eModal.iframe('https://'+ipservidorapache+'/calibrationfinalcheck.php?band=0&uldl=0&snmod='+snmodulo+'&idsndib='+snunit,'Calibration - Sn: '+ snmodulo);
	}	
	
	 function  callsupportit (idlog_view2, datosref)
 {
	// alert(idlog_view2);
	 
	 var userregistred = <?php echo "'".$_SESSION["b"]."'";?>;
	 var options = {
         message: " <div class='form-group'>Type: <select id='idtipoproblema' name='idtipoproblema' class='form-control form-control-sm'><option value='1'>CIU Confidential</option><option value='2'>Engineering Issue</option>	<option value='3'>FAS Bug</option><option value='4'>HW Issue</option><option value='5'>SO Issue</option><option value='6'>SOSPEC Issue</option><option value='7'>Specs issue</option><option value='8'>Webfas Bug</option></select></div> Issue:?  ",		   
	 title: 'Tech Support FAS',
        size: eModal.size.lg,
        subtitle: 'open an error ticket:  ' 
       
    };
	
		/*eModal.prompt(options)
      .then(callback, callbackCancel);*/
	  
	     return eModal
                .prompt(options)
                .then(
                    function (input) {
					//alert(input);
					toastr["info"]("Sending information...", "");			
					$.ajax({
				url: 'ajaxinsert_supportit.php', 				
				data: "idruninfodb="+idlog_view2+'&v_issue='+input+'-Ref:'+datosref+'&vuser='+userregistred+'&tp='+$('#idtipoproblema').val()+'&keyd='+datosref,	
				type: 'post',				
				datatype:'JSON',				
				cache:false,					
				success: function(data, status, xhr) {
					
				
					if (data =="ok" )
					{
						toastr["success"]("Save OK!", "");						
					}
					else	
					{
						toastr["error"]("Error when storing data...", "");						
					
					}
					return false;	
				
				},
				error: function(xhr, status, error) {
					 console.log(status);
				}
				});
					
					},
                    function (/**/) { $('#lbldatoserrr').html("ERROR: <br>"+resulterr); });
	 
 }
		
	function Call_printlabel_todos(vpara_ciu, vparamidorders)
	{
				console.log('si' + vpara_ciu);
				var ipservidorapache= '<?php echo $ipservidorapache; ?>';	
		eModal.iframe('https://'+ipservidorapache+'/labelprintermultisn.php?vciu='+vpara_ciu+'&vidord='+vparamidorders,'Label printing');
		$('.embed-responsive-item').height(380);
	//	console.log('si');
		

				setTimeout(function() {
								$('.embed-responsive-item').height(620);
							},300);
							
	}	
		
		
		
	function Call_printlabel(vpara_ciu,vparam_sn, vparamidorders)
	{
			var ipservidorapache= '<?php echo $ipservidorapache; ?>';	
		eModal.iframe('https://'+ipservidorapache+'/labelprintermultisn.php?vciu='+vpara_ciu+'&vsn='+vparam_sn+'&vidord='+vparamidorders,'Label printing');
		$('.embed-responsive-item').height(380);
	//	console.log('si');
		

				setTimeout(function() {
								$('.embed-responsive-item').height(620);
							},300);
							
							
	}	
	
	
		function openpopupframe2( snunit,vband, vuldl, vvidruninfopara, vnombreband)
	{
		//var ipservidor =<?php echo  $ipservidorapache;?>;
		var vvbdan ="";
		var vvuldl="";
		if (vband ==0)
		{
				vvbdan=vnombreband; //"700";
		}
		else
		{
				vvbdan=vnombreband; //"800";
		}
		if (vuldl ==0)
		{
			vvuldl="UP";
		}
		else
		{
				vvuldl="DL";
		}
		var ipservidorapache= '<?php echo $ipservidorapache; ?>';	
		eModal.iframe('https://'+ipservidorapache+'/finalchk.php?idsndib='+snunit+'&idmb='+vband+'&iduldl='+vuldl+'&idruninfo='+vvidruninfopara,'Calibration - SN:'+snunit+ '- Band:'+ vvbdan+ '-'+vvuldl);
		

	}	
		
	function save_new_rev()
		{
			var hagopost = 'S';
			if (document.getElementById("poselecm").value!="" ) 
			{
					
								if (document.getElementById("txtpwrsupply").value=="" ) 
								{
									hagopost = 'N';
								}
								if (document.getElementById("txtdlgain").value=="" ) 
								{
									hagopost = 'N';
								}
								if (document.getElementById("txtulgain").value=="" ) 
								{
									hagopost = 'N';
								}
								if (document.getElementById("txtdlmaxpwr").value=="" ) 
								{
									hagopost = 'N';
								}
								if (document.getElementById("txtulmaxpwr").value=="" ) 
								{
									hagopost = 'N';
								}
						if (hagopost == 'S')
						{							
							if (tabla_channel_quantity.length >= 1 )
							{
								if (tabla_gain_dlul.length >= 1  )	
								{
								//	alert('a');		

										if($("#txtrcgbwa").is(':checked')) {  
											   $("#vhtxtrcgbwa").val("true");
										} else {  
											$("#vhtxtrcgbwa").val("false");
										}  
										if($("#txtmoden").is(':checked')) {  
											   $("#vhtxtmoden").val("true");
										} else {  
											$("#vhtxtmoden").val("false");
										}  
								
								
									document.getElementById("myform").submit();
								}
								else
								{
									alert( "UNIT (DL - UL) List is required. ");	
								}
							}		
							else
							{
								alert( "Channel List is required. ");	
							}
						}
						else
						{
							alert( "Power Supply Type / Gain  / Max Pwr is required. ");	
						}
					
					
			}
			
		}
		
		
		/// -auto complete . multiselect.
		  var autocomplete = new SelectPure(".autocomplete-select-lossn", {
        options: [
          {
            label: "20036200FU",
            value: "20036200FU",
          },
          {
            label: "20036203FU",
            value: "20036203FU",
          },
          {
            label: "20036204FU",
            value: "20036204FU",
          },
          {
            label: "20036205FU",
            value: "20036205FU",
          },
          {
            label: "20036206FU",
            value: "20036206FU",
          },
          {
            label: "20036207FU",
            value: "20036207FU",
          },
          {
            label: "20036208FU",
            value: "20036208FU",
          },
          {
            label: "20036209FU",
            value: "20036209FU",
          },
        ],
        value: ["20036209FU","20036208FU"],
        multiple: true,
        autocomplete: true,
        icon: "fa fa-times",
        onChange: value => {  $("#lossnamodif").val(value); console.log(value); },
        classNames: {
          select: "select-pure__select",
          dropdownShown: "select-pure__select--opened",
          multiselect: "select-pure__select--multiple",
          label: "select-pure__label",
          placeholder: "select-pure__placeholder",
          dropdown: "select-pure__options",
          option: "select-pure__option",
          autocompleteInput: "select-pure__autocomplete",
          selectedLabel: "select-pure__selected-label",
          selectedOption: "select-pure__option--selected",
          placeholderHidden: "select-pure__placeholder--hidden",
          optionHidden: "select-pure__option--hidden",
        }
      });
      var resetAutocomplete = function() {
        autocomplete.reset();
      };
	  
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
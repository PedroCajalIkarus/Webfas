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
	//		echo "***********hola".time() - $_SESSION["timeout"];
        $sessionTTL = time() - $_SESSION["timeout"];
	//	echo $sessionTTL."-".$inactividad; 
        if($sessionTTL > $inactividad){
			session_unset();
            session_destroy();
            header("Location: http://".$ipservidorapache."/index.php?t=timeoutinactivityhome");
        }
	
    }
	else
	{
			session_unset();
            session_destroy();
            header("Location: http://".$ipservidorapache."/index.php?t=notcookietimeouthome");
        
	}
	
	$status = $connect->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	
	if ($status !="Connection OK; waiting to send.")
	{
	
		header("Location: http://".$ipservidorapache."/".$folderservidor."/errorconect.php");
		exit();
		
	}
	
//echo "aaa";
	
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
	/// FIN DETECTO PERMISOS EN PAG!
	
	$status = $connect->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	
	if ($status !="Connection OK; waiting to send.")
	{
	
		header("Location: http://".$ipservidorapache."/".$folderservidor."/errorconect.php");
		exit;
		
	}
	
			$sql = $connect->prepare("SELECT idband, description, fstartul, fstopul, fstartdl, fstopdl 	FROM idband ");
					$sql->execute();
					$resultado = $sql->fetchAll();
					 foreach ($resultado as $row2) {
						
						 $arr_idband[] = array("idband" => $row2['idband'],
													"fstartul" => $row2['fstartul'],
													"fstopul" => $row2['fstopul'],
													"fstartdl" => $row2['fstartdl'],
													"fstopdl" => $row2['fstopdl'],
													"nombreband"=> $row2['description']
													);
					 }
					 
	/*			
foreach($arr_idband as $producto => $detalles)
{
	//echo "<h1> $producto </h1>";
	//echo "MAM".$producto[0]->idband;
 foreach($detalles as $indice => $valor)
	{
		echo "<p>$producto --- $indice:$valor </p>";
	}
	
}
*/

//echo "Station:".$_SESSION["l"] ; 

if( $_SESSION["l"]  =="NN")
{
		header("Location: http://".$ipservidorapache."/".$folderservidor."/usertnotstation.php?b=".$_SESSION["b"]."&c=".array_pop(explode('/', $_SERVER['PHP_SELF'])));
		//	exit();
}

	// validamos POST DE DATOS
	if (isset($_POST['txtlistcustomers']))
	{
			$sql = $connect->prepare("select max(coalesce(idorders,0))+1 as cc from  orders ");
  
		$vconcero=0;
		$vvacio="";
		$v0 = $_REQUEST['txtlistcustomers']; ///$vidcustomer idtxtlistcustomers
		$v1 = $_REQUEST['txtlistcius']; /// idtxtlistcius
		$v2 = $_REQUEST['txtlistcius']; //txtlistcius 
		$v3 = $_REQUEST['txtponumber']; //
		$txtsonumberlu = $_REQUEST['txtsonumberlu']; //
		$v4 = $_REQUEST['txtpwrsupply']; //
		$vsaleordentmp = $_REQUEST['txtsonumber']; // txtsonumber		
		$v5 = $_REQUEST['txtrcgbwa']; ///$vidcustomer
		
		if ($v5=="")
		{
			//echo 
			$v5="FALSE";
		}
		$v6 = $_REQUEST['txtmoden']; ///
		if ($v6=="")
		{
			//echo 
			$v6="FALSE";
		}
		$v7 = $_REQUEST['dyhya']; // dyhya
		$v8 = $_REQUEST['txtdescripso']; //			
		$v13 = $_REQUEST['txtulgain']; //
		$v14 = $_REQUEST['txtulmaxpwr']; //
		$v15 = $_REQUEST['txtdlgain']; //
		$v16 = $_REQUEST['txtdlmaxpwr']; //
		
		$v21 = $_REQUEST['txtppassy']; //
		$v22 = $_REQUEST['txtreqcalib']; //
		$v23 = $_REQUEST['txtmatespecial']; //
		$v24 = $_REQUEST['txtotherchange']; //
		
		if ($v21=="")
		{
			//echo 
			$v21="false";
		}
		
		if ($v22=="")
		{
			//echo 
			$v22="false";
		}
		if ($v23=="")
		{
			//echo 
			$v23="false";
		}
		if ($v23=="on")
		{
			//echo 
			$v23="true";
		}
	
		if ($v24=="")
		{
			//echo 
			$v24="false";
		}
		if ($v24=="on")
		{
			//echo 
			$v24="true";
		}
		
		
		$v25 = $_SESSION["b"];
		$v26 = $_REQUEST['txtcant']; //
		
		$v27 = $_REQUEST['txtnotepo']; //
		$v28 = $_REQUEST['txtdescripmatesp']; //
		


		$varray_LISTCHANNEL = $_REQUEST['templistchannel']; //
		$varray_LISTDPX = $_REQUEST['templistadpx']; //
		
		$varray_LISTUNIT = $_REQUEST['templistagainuldl']; //
		
		
		
		
		
			$sql = $connect->prepare("select max(idorders) as cc from  orders ");
			$sql->execute();
					$resultado = $sql->fetchAll();
					 foreach ($resultado as $row) {
						$vmaxid= $row['cc']+1;
						
					 }
		
		
			/*		
			$checksumm = crc32( substr($v4,-2,2))."".crc32(date('yy'))."".crc32($v4)."".crc32($v5)."".crc32(date('m/d'))."".crc32(substr($v5,-2,2));
			$chkcrcm="false";
			if ($v7 == $checksumm)
			{
				$chkcrcm="true";
			}
			*/
		$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->beginTransaction();
			 try {
					//$connect->query($sql);
					$typeregister="PO";
					$nrowoautogenrado = "000000000".$vmaxid."PO";
					$nrowoautogenrado =   substr($nrowoautogenrado, -10); 
					
					///****** inserto orders de WO-----
					$sentencia = $connect->prepare("INSERT INTO orders(idorders, idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, idrev, idruninfo, date_approved, quantity, typeregister, processday, processfasserver, nameapproved ,active, fassrverror) VALUES (:idorders, :idcustomers, :idfamilyprod, :idtypeband, :idtypeproduct, :idproduct, :idconfiguration, :idrev, :idruninfo, now(), :quantity, :typeregister, :processday, :processfasserver, :nameapproved,:active, :fassrverror);");
														
					$sentencia->bindParam(':idorders', $vmaxid);
					$sentencia->bindParam(':idcustomers', $v0);
					$sentencia->bindParam(':idfamilyprod', $vconcero);
					$sentencia->bindParam(':idtypeband', $vconcero);
					$sentencia->bindParam(':idtypeproduct', $vconcero);
					
					$sentencia->bindParam(':idproduct', $v1);
					$sentencia->bindParam(':idconfiguration', $vconcero);				
					$sentencia->bindParam(':idrev', $vconcero);					
					$sentencia->bindParam(':idruninfo', $vconcero);
					$sentencia->bindParam(':quantity', $v26);		
					$sentencia->bindParam(':typeregister', $typeregister);	
					
					$vvacionull=null;
					$vprocessdas="false";
					$sentencia->bindParam(':processday', $vvacionull );		
					$sentencia->bindParam(':processfasserver', $vprocessdas);
				$sentencia->bindParam(':nameapproved', $v25);	
			$activereg = "Y";
					$sentencia->bindParam(':active', $activereg);					
					$sentencia->bindParam(':fassrverror', $vvacio);							
							
					$sentencia->execute();
					
					///****** inserto orders de WO-----
					$sentencia = $connect->prepare("INSERT INTO orders_sn(idorders, idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, idrev, idnroserie,
					so_soft_external,wo_serialnumber, idruninfo, ponumber, pwrsupplytype, rcgfbwa, moden_dig, date_approved, descripcion,	ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, 
					req_ppassy, req_calibration,	req_spec, req_other, nameapproved, notes, reqresources, typeregister, processday, processfasserver, so_original, so_associed) VALUES (:idorders, :idcustomers, :idfamilyprod, :idtypeband, :idtypeproduct, :idproduct, :idconfiguration, :idrev, :idnroserie, :so_soft_external, :wo_serialnumber, :idruninfo, :ponumber, :pwrsupplytype, :rcgfbwa, :moden_dig, :date_approved, :descripcion, :ul_gain, :ul_max_pwr, :dl_gain, :dl_max_pwr, :req_ppassy, :req_calibration, :req_spec, :req_other, :nameapproved, :notes, :reqresources, :typeregister, :processday, :processfasserver, :so_original, :so_associed);");
					
					$sentencia->bindParam(':idorders', $vmaxid);
					$sentencia->bindParam(':idcustomers', $v0);
					$sentencia->bindParam(':idfamilyprod', $vconcero);
					$sentencia->bindParam(':idtypeband', $vconcero);
					$sentencia->bindParam(':idtypeproduct', $vconcero);
					$sentencia->bindParam(':idproduct', $v1);
					$sentencia->bindParam(':idconfiguration', $vconcero);				
					$sentencia->bindParam(':idrev', $vconcero);	
					$sentencia->bindParam(':idnroserie', $vconcero);						
					$sentencia->bindParam(':so_soft_external', $txtsonumberlu );
					$sentencia->bindParam(':wo_serialnumber', $vvacio);
					$sentencia->bindParam(':idruninfo', $vconcero);					
					$sentencia->bindParam(':ponumber', $v3);					
					$sentencia->bindParam(':pwrsupplytype', $v4);
					$sentencia->bindParam(':rcgfbwa', $v5);
					$sentencia->bindParam(':moden_dig', $v6);
					$sentencia->bindParam(':date_approved', $v7);					
					$sentencia->bindParam(':descripcion', $v8);
					$sentencia->bindParam(':ul_gain', $v13);
					$sentencia->bindParam(':ul_max_pwr', $v14);
					$sentencia->bindParam(':dl_gain', $v15);
					$sentencia->bindParam(':dl_max_pwr', $v16);					
				
					$sentencia->bindParam(':req_ppassy', $v21);
					$sentencia->bindParam(':req_calibration', $v22);
					$sentencia->bindParam(':req_spec', $v23);
					$sentencia->bindParam(':req_other', $v24);
					$sentencia->bindParam(':nameapproved', $v25);
					$sentencia->bindParam(':notes', $v27);		
					$sentencia->bindParam(':reqresources', $v28);	
					$sentencia->bindParam(':typeregister', $typeregister);						
					$vvacionull=null;
					$vprocessdas="false";
					$sentencia->bindParam(':processday', $vvacionull );		
					$sentencia->bindParam(':processfasserver', $vprocessdas);	
					$sentencia->bindParam(':so_original', $vvacio);	
					$sentencia->bindParam(':so_associed', $vvacio);	
					$sentencia->execute();
						
						/////////////////////////////////////////////////////////////////////////////////////
						//////AUDITAMOS///////////////////////////////////////////////////////////////////////////////
						$vuserfas = $_SESSION["b"];
						$typeregister="PO";
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="INSERT PO";
						$vdescripaudit="NEW REG PO".$vuserfas;
						$vtextaudit="INSERT INTO orders_sn(idorders, idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, idrev, idnroserie, so_soft_external, wo_serialnumber, idruninfo, ponumber, pwrsupplytype, rcgfbwa, moden_dig, date_approved, descripcion,	ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, nameapproved, notes, reqresources, typeregister, processday, processfasserver, so_original, so_associed ) VALUES (:idorders, :idcustomers, :idfamilyprod, :idtypeband, :idtypeproduct, :idproduct, :idconfiguration, :idrev, :idnroserie, :so_soft_external, :wo_serialnumber, :idruninfo, :ponumber, :pwrsupplytype, :rcgfbwa, :moden_dig, :date_approved, :descripcion, :ul_gain, :ul_max_pwr, :dl_gain, :dl_max_pwr, :req_ppassy, :req_calibration, :req_spec, :req_other, :nameapproved, :notes, :reqresources, :typeregister, :processday, :processfasserver, :so_original, :so_associed?);";
						$vtextaudit=$vtextaudit."!!idorders:".$vmaxid;
						$vtextaudit=$vtextaudit."!!idcustomers:".$v0;
						$vtextaudit=$vtextaudit."!!idproduct:".$v1;
						$vtextaudit=$vtextaudit."!!ponumber:".$v3;
						$vtextaudit=$vtextaudit."!!txtsonumberlu:".$txtsonumberlu;
						$vtextaudit=$vtextaudit."!!pwrsupplytype:".$v4;
						$vtextaudit=$vtextaudit."!!rcgfbwa:".$v5;
						$vtextaudit=$vtextaudit."!!moden_dig:".$v6;
						$vtextaudit=$vtextaudit."!!date_approved:".$v7;
						$vtextaudit=$vtextaudit."!!descripcion:".$v8;
						$vtextaudit=$vtextaudit."!!ul_gain:".$v13;
						$vtextaudit=$vtextaudit."!!ul_max_pwr:".$v14;
						$vtextaudit=$vtextaudit."!!dl_gain:".$v15;
						$vtextaudit=$vtextaudit."!!dl_max_pwr:".$v16;
						
						$vtextaudit=$vtextaudit."!!req_ppassy:".$v21;
						$vtextaudit=$vtextaudit."!!req_calibration:".$v22;
						$vtextaudit=$vtextaudit."!!req_spec:".$v23;
						$vtextaudit=$vtextaudit."!!req_other:".$v24;
						$vtextaudit=$vtextaudit."!!nameapproved:".$v25;
						$vtextaudit=$vtextaudit."!!quantity:".$v26;
						$vtextaudit=$vtextaudit."!!notes:".$v27;
						$vtextaudit=$vtextaudit."!!reqresources:".$v28;
						$sentencia->bindParam(':typeregister', $typeregister);		
				
								$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();
				/////////////////////////////////////////////////////////////////////////////////////
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
								$sentenciach = $connect->prepare("INSERT INTO public.orders_sn_specs(idorders, idrev, idch, idnroserie, typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, notes)	VALUES (:idorders, :idrev, :idch, :idnroserie, :typedata, :ul_ch_fr, :dl_ch_fr, :dpxlowstart, :dpxlowstop, :dpxhihgstart, :dpxhihgstop, :unitdlstart, :unitdlstop, :unitulstart, :unitulstop, :notes);");
								
								$sentenciach->bindParam(':idorders', $vmaxid);								
								$sentenciach->bindParam(':idrev', $vconcero);
								$sentenciach->bindParam(':idch', $vidch);
								$sentenciach->bindParam(':idnroserie', $vconcero);
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
								$vdescripaudit="NEW REG presales_specs".$vuserfas;		
								$vtextaudit="INSERT INTO public.orders_sn_specs(idorders, idrev, idch, idnroserie, typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, notes)	VALUES (:idorders, :idrev, :idch, :idnroserie, :typedata, :ul_ch_fr, :dl_ch_fr, :dpxlowstart, :dpxlowstop, :dpxhihgstart, :dpxhihgstop, :unitdlstart, :unitdlstop, :unitulstart, :unitulstop, :notes);";
								$vtextaudit=$vtextaudit."!!idorders:".$vmaxid;
								$vtextaudit=$vtextaudit."!!idrev:".$vconcero;
								$vtextaudit=$vtextaudit."!!idch:".$vidch;
								$vtextaudit=$vtextaudit."!!typedata:".$vtypedata;
								$vtextaudit=$vtextaudit."!!ul_ch_fr:".$separa_ULDL[1];
								$vtextaudit=$vtextaudit."!!dl_ch_fr:".$separa_ULDL[0];
							
								
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();								
								
								/////////////////////////////////////////////////////////////////////////////////////
								/////////////////////////////////////////////////////////////////////////////////////	
									
								$vidch = $vidch + 1 ;	
							}
							
						}
					 //$varray_LISTDPX
						$vvidband =5;  //UNKNOW
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
									//$vnotech  = $separa_DPX[0]."*".$_REQUEST['txtnotedpc']; //
									$vnotech  = $_REQUEST['txtnotedpc']; //
									 //UNKNOW
									$vvidband =5;  //UNKNOW
									foreach ($arr_idband as $key => $value) {
										//	echo $key . ":  " . $value['idband'] . "-" . $value['fstartul']. "-" . $value['fstopul']. "-" . $value['fstartdl']. "-" . $value['fstopdl'] . "<br>";
											if ( $value['fstartdl'] == $separa_DPX[1]  && $value['fstopdl'] == $separa_DPX[2] && $value['fstartul'] == $separa_DPX[3] && $value['fstopul'] == $separa_DPX[4])
											{
												$vvidband = $value['idband'];
											}
									}

				
			$sentenciach = $connect->prepare("INSERT INTO public.orders_sn_specs(idorders, idrev, idch, idnroserie, typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, notes, idband)	VALUES (:idorders, :idrev, :idch, :idnroserie, :typedata, :ul_ch_fr, :dl_ch_fr, :dpxlowstart, :dpxlowstop, :dpxhihgstart, :dpxhihgstop, :unitdlstart, :unitdlstop, :unitulstart, :unitulstop, :notes, :idband);");
								$sentenciach->bindParam(':idorders', $vmaxid);								
								$sentenciach->bindParam(':idrev', $vconcero);
								$sentenciach->bindParam(':idch', $vidchdpx);
								$sentenciach->bindParam(':idnroserie', $vconcero);
								$sentenciach->bindParam(':typedata', $vtypedata);
								$sentenciach->bindParam(':ul_ch_fr', $vconcero);
								$sentenciach->bindParam(':dl_ch_fr', $vconcero);
								$sentenciach->bindParam(':dpxlowstart', $separa_DPX[5]); //1
								$sentenciach->bindParam(':dpxlowstop', $separa_DPX[6]); //2
								$sentenciach->bindParam(':dpxhihgstart',$separa_DPX[7]); //3
								$sentenciach->bindParam(':dpxhihgstop', $separa_DPX[8]); //4
								$sentenciach->bindParam(':unitdlstart', $vconcero);
								$sentenciach->bindParam(':unitdlstop', $vconcero);
								$sentenciach->bindParam(':unitulstart', $vconcero);
								$sentenciach->bindParam(':unitulstop', $vconcero);
								$sentenciach->bindParam(':notes', $vnotech);
								$sentenciach->bindParam(':idband', $vvidband);
									
								$sentenciach->execute();
								
								/////////////////////////////////////////////////////////////////////////////////////
								/////////////////////////////////////////////////////////////////////////////////////								
								$vdescripaudit="NEW REG presales_specs".$vuserfas;		
								$vtextaudit="INSERT INTO public.orders_sn_specs(idorders, idrev, idch, idnroserie, typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, notes,idband)	VALUES (:idorders, :idrev, :idch, :idnroserie, :typedata, :ul_ch_fr, :dl_ch_fr, :dpxlowstart, :dpxlowstop, :dpxhihgstart, :dpxhihgstop, :unitdlstart, :unitdlstop, :unitulstart, :unitulstop, :notes,:idband);";
								$vtextaudit=$vtextaudit."!!idorders:".$vmaxid;
								$vtextaudit=$vtextaudit."!!idrev:".$vconcero;
								$vtextaudit=$vtextaudit."!!idch:".$vidch;
								$vtextaudit=$vtextaudit."!!typedata:".$vtypedata;
								$vtextaudit=$vtextaudit."!!dpxlowstart:".$separa_DPX[5]; //1
								$vtextaudit=$vtextaudit."!!dpxlowstop:".$separa_DPX[6]; //2
								$vtextaudit=$vtextaudit."!!dpxhihgstart:".$separa_DPX[7]; //3
								$vtextaudit=$vtextaudit."!!dpxhihgstop:".$separa_DPX[8]; //4
								$vtextaudit=$vtextaudit."!!idband:".$vvidband;
							
								
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();								
								
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
								
										$vvidband =5;  //UNKNOW
									foreach ($arr_idband as $key => $value) {
										//	echo $key . ":  " . $value['idband'] . "-" . $value['fstartul']. "-" . $value['fstopul']. "-" . $value['fstartdl']. "-" . $value['fstopdl'] . "<br>";
											if ( $value['fstartdl'] == $separa_UNIT[1]  && $value['fstopdl'] == $separa_UNIT[2] && $value['fstartul'] == $separa_UNIT[3] && $value['fstopul'] == $separa_UNIT[4])
											{
												$vvidband = $value['idband'];
											}
									}
									
									
							//	$vnotech  =  $separa_UNIT[0]."*".$_REQUEST['txtnotedpc']; //
								$vnotech  =  $_REQUEST['txtnotedpc']; //
								$sentenciach = $connect->prepare("INSERT INTO public.orders_sn_specs(idorders, idrev, idch, idnroserie, typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, notes,idband, ulgain, dlgain,ulmaxpwr,dlmaxpwr)	VALUES (:idorders, :idrev, :idch, :idnroserie, :typedata, :ul_ch_fr, :dl_ch_fr, :dpxlowstart, :dpxlowstop, :dpxhihgstart, :dpxhihgstop, :unitdlstart, :unitdlstop, :unitulstart, :unitulstop, :notes,:idband, :ulgain, :dlgain, :ulmaxpwr, :dlmaxpwr);");
								$sentenciach->bindParam(':idorders', $vmaxid);								
								$sentenciach->bindParam(':idrev', $vconcero);
								$sentenciach->bindParam(':idch', $vidchunit);
								$sentenciach->bindParam(':idnroserie', $vconcero);
								$sentenciach->bindParam(':typedata', $vtypedata);
								$sentenciach->bindParam(':ul_ch_fr', $vconcero);
								$sentenciach->bindParam(':dl_ch_fr', $vconcero);
								$sentenciach->bindParam(':dpxlowstart', $vconcero);
								$sentenciach->bindParam(':dpxlowstop', $vconcero);
								$sentenciach->bindParam(':dpxhihgstart',$vconcero);
								$sentenciach->bindParam(':dpxhihgstop', $vconcero);
								$sentenciach->bindParam(':unitdlstart', $separa_UNIT[5]); // 0
								$sentenciach->bindParam(':unitdlstop', $separa_UNIT[6]);
								$sentenciach->bindParam(':unitulstart',$separa_UNIT[7]);
								$sentenciach->bindParam(':unitulstop', $separa_UNIT[8]);

								$sentenciach->bindParam(':ulgain', $separa_UNIT[9]); // 0
								$sentenciach->bindParam(':dlgain', $separa_UNIT[10]);
								$sentenciach->bindParam(':ulmaxpwr',$separa_UNIT[11]);
								$sentenciach->bindParam(':dlmaxpwr', $separa_UNIT[12]);

								
////UHF FULL|450|512|450|512| 123| 34| 345|     666|79.4|79.4|24|27.7|
									$sentenciach->bindParam(':notes', $vnotech);
									$sentenciach->bindParam(':idband', $vvidband);
								$sentenciach->execute();
								
								/////////////////////////////////////////////////////////////////////////////////////
								/////////////////////////////////////////////////////////////////////////////////////								
								$vdescripaudit="NEW REG presales_specs".$vuserfas;		
								$vtextaudit="INSERT INTO public.orders_sn_specs(idorders, idrev, idch, idnroserie, typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, notes,idband)	VALUES (:idorders, :idrev, :idch, :idnroserie, :typedata, :ul_ch_fr, :dl_ch_fr, :dpxlowstart, :dpxlowstop, :dpxhihgstart, :dpxhihgstop, :unitdlstart, :unitdlstop, :unitulstart, :unitulstop, :notes,:idband);";
								$vtextaudit=$vtextaudit."!!idorders:".$vmaxid;
								$vtextaudit=$vtextaudit."!!idrev:".$vconcero;
								$vtextaudit=$vtextaudit."!!idch:".$vidch;
								$vtextaudit=$vtextaudit."!!typedata:".$vtypedata;
								$vtextaudit=$vtextaudit."!!unitdlstart:".$separa_UNIT[1];
								$vtextaudit=$vtextaudit."!!unitdlstop:".$separa_UNIT[2];
								$vtextaudit=$vtextaudit."!!unitulstart:".$separa_UNIT[3];
								$vtextaudit=$vtextaudit."!!unitulstop:".$separa_UNIT[4];
									$vtextaudit=$vtextaudit."!!idband:".$vvidband;
							
								
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();								
								
								/////////////////////////////////////////////////////////////////////////////////////
								/////////////////////////////////////////////////////////////////////////////////////	
								
								$vidchunit = $vidchunit + 1 ;	
							}
							
						}
						
						$query_lista ="INSERT INTO orders_states(idorders, idstate, datestate)	VALUES (".$vmaxid.", 1,   (now() - interval '2 minute') );";
						$connect->query($query_lista);

						$query_lista ="INSERT INTO orders_states(idorders, idstate, datestate)	VALUES (".$vmaxid.", 2,  (now() - interval '1 minute') );";
						$connect->query($query_lista);		

						if ( $txtsonumberlu <> "")
						{
							$query_lista ="INSERT INTO orders_states(idorders, idstate, datestate)	VALUES (".$vmaxid.", 3, now());";
							$connect->query($query_lista);		

						}
						
						$msjalertglobo="New PO: ".$v3." to process";
						$msjlink="listpresales.php";
						$query_lista2 ="INSERT INTO notices_users select ( select count(idnotice)+1 from notices_users),1 ,".$_SESSION["i"].", now(), null, '$msjalertglobo', '$msjlink'";						
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
						
						$vdescripaudit="NEW REG presales_states  -  notices_users";		
								$vtextaudit="INSERT INTO presales_states(idpresales, idstate, datestate)	VALUES (".$vmaxid.", 1, now()); // users in(1,2,17,16,11,20,)";
						
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
							  confirmButtonText: 'Ok',
							  
							}).then((result) => {
							  if (result.value) 
							  {
								window.location="listpresales.php"; 
							  }
							  else
							  {
								 window.location="listpresales.php";
							  }
							})
							
					/*Swal.fire({
							  title: 'PO Saved!',
							  text: "Add a new PO ?",
							  icon: 'success',
							  showCancelButton: true,
							  confirmButtonColor: '#3085d6',
							  cancelButtonColor: '#d33',
							  confirmButtonText: 'Yes',
							  cancelButtonText: 'No', 
							}).then((result) => {
							  if (result.value) 
							  {
								window.location="generarsaleorders.php"; 
							  }
							  else
							  {
								 window.location="listpresales.php";
							  }
							})*/

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
				}
	}
	
//	echo ".......................................................".$return_result_insert;
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
  
  <!-- AdminLTE css -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->

  
  <link rel="shortcut icon" href="fiplexcirculo-01.ico" />

 
 <link rel="stylesheet" href="cssfiplexsintextareaslog.css">

<link href="css/select2.css" rel="stylesheet" />
<link href="css/testcssselector.css" rel="stylesheet" />

    <link href="smoke/css/smoke.css" rel="stylesheet">
	
</head>
<style>
.colorfondonaranja
{
	border-style: solid;
  border-color:rgba(0, 83, 161, 0.8);
  background-color:rgba(250, 5, 5, 0.4);
  font-weight: bold;

}
</style>

<form name="frma" id="frma">
<input type="hidden" name="uso" id="uso" value="0">
<body class="hold-transition sidebar-mini sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
 
  <!-- /.navbar -->
<?php 	  
 include("menutopnotification.php"); 
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
		    <?php if ($_REQUEST["add"]=="" )
					  {
						  ?>
						<h1>Create PreSales</h1>
					  <?php }
					  else
					  {
						  ?>
						  <h1>Add CIU to PreSales</h1>
						  <?php
					  }?>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Create PO </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
   
		<section class="col-lg-12 connectedSortable ui-sortable">
		

				<div class="card">
				<div class="card-header ui-sortable-handle" >
               	
				<?php
				if ($return_result_insert=="ok")
				{
					?>
					<div class="alert alert-success alert-dismissible">
					  
					  <h5><i class="icon fas fa-check"></i> Saved!</h5>					  
					</div>
					<?php
				
				}
				?>	
			
				  <p align="right">
			<a href="listpresales.php" style="color:#0053a1;"><i class='fas fa-search' style='font-size:24px;color:#0053a1;'></i>  &nbsp;List PO</a> &nbsp;&nbsp;
			<hr>
			</p>

				  
			<!-- aca form -->
			
			      <form action="changeuserfasdata.php" method="post" class="form-horizontal" name="frmpass" id="frmpass">
	
	
			
				  
      </form>
		
	 
							 <form  action="generarsaleordersmm.php" method="post" class="form-horizontal" id="myform" name="myform">
				  <!-- NUEVO RENGLON FORM  -->
				  <div class="form-group row">
					<label for="statiCustomer" class="col-sm-2 col-form-label">Customer</label>
					<div class="col-sm-10">
						
						
							<select class="js-example-basic-single col-sm-6"  id="txtlistcustomers" name="txtlistcustomers" required onchange="list_po_by_customer(this.value)">
							  <option value="">Select Customer </option>
							<?php
							
								$query_lista = list_all_customers(""); 	
								$data = $connect->query($query_lista)->fetchAll();	
								foreach ($data as $row) {			

									//$return_arr[] = array("id" => $row[0], "name" => $row[1]);		
									echo  "<option value=".$row[0].">".strtoupper($row[1])."</option>";
								 }
							?>
							
								</select>
							
							
						&nbsp;&nbsp;<a href="createcustomer.php"><i class='fas fa-user-alt'></i> Add Customer</a>
							

					</div>
				  </div>
				  <!-- NUEVO RENGLON FORM  -->
				  <div class="form-group row">
					<label for="inputPassword" class="col-sm-2 col-form-label">PO Number</label>
					<div class="col-sm-4	">
					  <?php if ($_REQUEST["add"]=="Y" )
					  {
						  ?> <select class="js-example-basic-single col-sm-6"  id="txtponumber" name="txtponumber"  required onchange="list_po_by_customer_andpo(this.value)" >
							  <option value="">Select Customer </option>
							</select>
						  <?php
					  }
					  else
					  { 
						?>
					  <input type="text" class="form-control" id="txtponumber" name="txtponumber" onblur="chequearpootrocliente(this.value)" required placeholder="PO Number">
					  <?php } ?>
					  
					</div>
					
					<div class="col-sm-4">
					 
					</div>
				  </div>
				    <div class="form-group row">
					<label for="inputPassword" class="col-sm-2 col-form-label">SO Number</label>
					<div class="col-sm-4	">
					
					
					
					 <?php if ($_REQUEST["add"]=="Y" )
					  {
						  ?> <select class="js-example-basic-single col-sm-6"  id="txtsonumberlu" name="txtsonumberlu"  required>
							  <option value="">Select Customer </option>
							</select>
						  <?php
					  }
					  else
					  { 
						?>
					  
					  <input type="text" class="form-control" id="txtsonumberlu" name="txtsonumberlu"  required placeholder="SO Number" onblur="chequearso_usado(this.value)" >
					  <?php } ?>
					  
					
					  
					
					  
					</div>
					
					<div class="col-sm-4">
					 
					</div>
				  </div>
				  <!-- NUEVO RENGLON FORM  -->

						<br>
						<div class="progress progress-xxs">
							 <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
							 </div>
						</div>
						<br>
					<!-- NUEVO RENGLON FORM  -->
					<div class="form-group row" >
					<label for="inputPassword" class="col-sm-1 col-form-label">Ciu Model:</label>
					<div class="col-sm-6	">
					
						<select class="js-example-basic-single col-sm-8" required  id="txtlistcius" name="txtlistcius">
						</select>
					
					
					
						</div>
					<label for="inputPassword" class="col-sm-1 col-form-label">Quantity:</label>
					<div class="col-sm-3">
					<input type="number" class="form-control col-3" id="txtcant" name="txtcant" data-smk-type="number" min="1"  data-validate="true" required placeholder="quantity" value="1">	

					</div>
				  </div>
					<!-- NUEVO RENGLON FORM  -->
		<div id="frmwo" name="frmwo">
				 
				  
				  <div class="progress progress-xxs">
							 <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
							 </div>
						</div>
						<br>
						
					<!-- NUEVO RENGLON FORM  -->
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
								<select  id="txtpwrsupply" name="txtpwrsupply"  class="custom-select my-1 mr-sm-2 form-control" required data-validate="true">
								<option value="">-select-</option>
								<option value="AC">AC</option>
								<option value="DC">DC</option>
								<option value="AC/DC">AC/DC</option>
								
						
								</select>
					</div>
					<label for="inputPassword" class="col-sm-1 col-form-label">RC-G for BWA:</label>
					<div class="col-sm-1">
						
						<input type="checkbox"  data-toggle="toggle"  data-off="NO" data-on="YES" id="txtrcgbwa" name="txtrcgbwa" data-validate="true">
					</div>
					<label for="inputPassword" class="col-sm-1 col-form-label">Modem for Digital:</label>
					<div class="col-sm-1">
						<input type="checkbox"  data-toggle="toggle" data-on="YES" data-off="NO" id="txtmoden" name="txtmoden" data-validate="true">
						

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


				
<br><br>


				<input type="hidden"  id="templistagainuldl" name="templistagainuldl" value="aaaaa">
					<div class="col-sm-12">
					
							
						
				
						<div class="col-sm-12" id="listagainuldl" name="listagainuldl" >
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
				  
				  <br>
						<div class="progress progress-xxs">
							 <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
							 </div>
						</div>
						<br>
							<!-- NUEVO RENGLON FORM  -->
					<div class="form-group row">
					<input type="hidden" class="form-control" id="templistadpx" name="templistadpx">
					<div class="col-sm-12">
				
						
					
						<div class="col-sm-12" id="listadpx" name="listadpx" >
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
					   <label  class="col-sm-2 col-form-label">DL Channels (MHz):</label>  <input type="number" min="1" class="form-control" data-validate="false" id="txtchud" name="txtchud" placeholder="000.000">
					  <label  class="col-sm-2 col-form-label">UL Channels (MHz):	</label>    <input type="number" min="1" class="form-control" data-validate="false" id="txtchul" name="txtchul" placeholder="000.000"> 
						<button name="btnaddchannels" id="btnaddchannels" type="button" class="btn btn-smk btn-outline-primary btn-flat" onclick="add_channels()">Add to Channel List</button>
						<input type="hidden" class="form-control" id="templistchannel" name="templistchannel">
					
						<p align="right" >
						<button name="btnaddchannels" id="btnaddchannels" type="button" class="btn btn-sm btn-outline-primary btn-flat" onclick="importar_channell()">Import Channel </button>
						<div class="container d-none" id="importador" name="importador" >
  <div class="row">
    <div class="col">	DL Channels :: copy and paste the channels here
						<textarea class="form-control" id="importchdl" name="importchdl" rows="2"></textarea></div>
    <div class="col">	UL Channels :: copy and paste the channels here
						<textarea class="form-control" id="importchul" name="importchul"  rows="2"></textarea></div>
   
  </div>
  				<button name="btnaddchannels" id="btnaddchannels" type="button" class="btn btn-sm btn-outline-primary btn-flat" onclick="importar_nowl()">Import now </button>
  </div>
					
					
    					</p>

					</div>
					
					<div class="col-sm-6">
						<div class="col-sm-12" id="listachannel" name="listachannel" >
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
						<!-- NUEVO RENGLON FORM  -->
					<div class="form-group row">
					
							<label for="inputPassword" class="col-sm-1 col-form-label">Training required for PP-ASSY</label>
							<div class="col-sm-2">
							<input type="checkbox"  data-toggle="toggle" data-on="YES" data-off="NO" id="txtppassy" name="txtppassy" >
							</div>  
							<label for="inputPassword" class="col-sm-1 col-form-label">Training required for Calibration</label>
							<div class="col-sm-2">
							<input type="checkbox"  data-toggle="toggle" data-on="YES" data-off="NO" id="txtreqcalib" name="txtreqcalib" >
							</div>  
							<label for="inputPassword" class="col-sm-1 col-form-label">Special Material required</label>
							<div class="col-sm-2">
							<input type="checkbox"  data-toggle="toggle" data-on="YES" data-off="NO" id="txtmatespecial" name="txtmatespecial" >
							</div> 
						<label for="inputPassword" class="col-sm-1 col-form-label">Other</label>
							<div class="col-sm-2">		
							<input type="checkbox"  data-toggle="toggle"  data-on="YES"  data-off="NO" id="txtotherchange" name="txtotherchange" >
							</div>			
						</div>  
					<!-- NUEVO RENGLON FORM  -->
								  <!-- NUEVO RENGLON FORM  -->
					<div class="form-group row">
					<label for="inputPassword" class="col-sm-2 col-form-label">Description of Resources Required:</label>
					<div class="col-sm-10">
					   <textarea class="form-control" id="txtdescripmatesp" name="txtdescripmatesp" rows="4"></textarea>
					  
					</div>
						
				  </div>
		</div>		  					  <!-- NUEVO RENGLON FORM  -->
					<div class="form-group row">
					
					<div class="col-sm-10">
					  
					  
					</div>
						<div class="col-sm-2">
						<button type="button" class="btn btn-primary btn-block" id="btnchangep" name="btnchangep">Create New PO</button>
					</div>
				  </div>
				  
				
  
    <!-- NUEVO RENGLON FORM  -->  
		


	 			 
		
				  
              
				</div>	
				</div>	
		 </section>
          <!-- /.col -->
        </div>
   

    </section>
    <!-- /.content -->
	
	
	
  </div>
  <!-- /.content-wrapper -->
  


<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Server Time:</b> 
	 <input type="hidden" id="dyhya" name="dyhya" value="">	   
<span name="date-part" id="date-part"></span>
<span name="time-part" id="time-part"></span>
    </div>
    <strong>Copyright &copy; 2020 Admin Fas FIPLEX</strong> All rights
    reserved.
  </footer>
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
  <link href="css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="js/bootstrap4-toggle.min.js"></script>
<script src="js/bootstrap-typeahead.js"></script>


<script src="js/select2.min.js"></script>
	
</body>



<script type="text/javascript">

//variable Global
 var tabla_cui_cant = [];
  var tabla_channel_quantity = [];
var tabla_gain_dlul= [];
var tabla_dpx =[];


function soloNumeros(e){
	var key = window.Event ? e.which : e.keyCode
	return (key >= 48 && key <= 57 || key==46  )
}






function formatRepo (repo) {
	
  if (repo.loading) {
    return repo.text;
  }

  var $container = $(
    "<div class='select2-result-repository clearfix'>" +
      "<div class='select2-result-repository__avatar'><img src='img/imgciu.jpg' /></div>" +
      "<div class='select2-result-repository__meta'>" +
        "<div class='select2-result-repository__title'></div>" +
        "<div class='select2-result-repository__description'></div>" +      
      "</div>" +
    "</div>"
  );

  $container.find(".select2-result-repository__title").text(repo.text);
  $container.find(".select2-result-repository__description").html(repo.description+' ** ' + repo.link);
  $container.find(".select2-result-repository__forks").append("101" + " Forks");
  $container.find(".select2-result-repository__stargazers").append("102" + " Stars");
  $container.find(".select2-result-repository__watchers").append("103" + " Watchers");
//  console.log(repo.text);
  return $container;
}

function formatRepoSelection (repo) {
	// console.log('1' + repo.text);
  return repo.full_name || repo.text;
}

   
	$( document ).ready(function() {
		
		
		   $('.js-example-basic-single').select2();
		
		
			$("#txtlistcius").change(function(){
				var tabla_info_show_po = "";	

//Limpiamos Array de CH UNI DPX	

console.log(tabla_channel_quantity.length);
   tabla_channel_quantity.length=0;
 tabla_gain_dlul.length=0;
 tabla_dpx.length=0;					
					
				 $.ajax
				({ 
					url: 'checksousadowo.php',
					data: "idproduct="+ $("#txtlistcius").val(),	
					type: 'post',				
					datatype:'JSON',                
					success: function(data)
					{
			 		//	console.log(data.woparam);
						if (data.woparam ==false)
						{
							$("#frmwo").addClass('d-none');	
						}
						else
						{
							$("#frmwo").removeClass('d-none');	
							//PRECARGAMOS
							if (data.powersupply =="AC")
							 {
								document.getElementById("txtpwrsupply").selectedIndex =1; 
							 }
							if (data.powersupply =="DC")
							 {
								 document.getElementById("txtpwrsupply").selectedIndex =2;
							 }
							 if (data.powersupply =="AC/DC")
							 {
								 document.getElementById("txtpwrsupply").selectedIndex =3;
							 }
							 /*  $("#txtdlgain").val(data.dlgain);
							   $("#txtdlmaxpwr").val(data.dlmaxpwr);
							   $("#txtulgain").val(data.ulgain);
							   $("#txtulmaxpwr").val(data.ulmaxpwr);*/

							   var v_gain_ul = parseFloat(data.ulgain);
		var v_gain_dl = parseFloat(data.dlgain);
		var v_maxpwr_ul = parseFloat(data.ulmaxpwr);
		var v_maxpwr_dl = parseFloat(data.dlmaxpwr);
							   /* a pedido de lea par TEST
							    $("#btnlist_gain").addClass('d-none'); 
							    $("#btnlist_dpx").addClass('d-none'); 
								  $("#btnaddchannels").addClass('d-none'); 
								  */
								  
							 tabla_info_show_wo="<table class='table table-striped '><tbody>";
								tabla_info_show_po=tabla_info_show_po+"<tr><th><b>UNIT (DL - UL) List</b></th><td></td><td></td><td></td></tr>";		
								 var note_unit = "";
								 $.each(data.arr_dpxunit, function(i, itempsunit) {
										note_unit = itempsunit.nomband;
											tabla_info_show_po=tabla_info_show_po+"<tr><td>"+note_unit+" Unit DL: Start: <b>"+itempsunit.fstartdl+"</b> MHz</td><td>Unit DL: Stop: <b>"+itempsunit.fstopdl+"</b> MHz</td><td>Unit UL: Start: <b>"+itempsunit.fstartul+"</b> MHz</td> <td>Unit UL: Stop: <b>"+itempsunit.fstopul+"</b> MHz</td></tr>";		
											
											if (itempsunit.nomband.indexOf('700') >=0 || itempsunit.nomband.indexOf('800')>=0)	
											{
												tabla_gain_dlul.push({	
												Band:itempsunit.nomband,
												hiddengainudstart: parseFloat(itempsunit.fstartdl),
												hiddengainudstop: parseFloat(itempsunit.fstopdl),
												hiddengainulstart: parseFloat(itempsunit.fstartul),
												hiddengainulstop: parseFloat(itempsunit.fstopul), 
												DL_Start:  parseFloat(itempsunit.fstartdl),
												DL_Stop: parseFloat(itempsunit.fstopdl),
												UL_Start: parseFloat(itempsunit.fstartul),
												UL_Stop:  parseFloat(itempsunit.fstopul), 
												noteditUL_gain: parseFloat(v_gain_ul),
												noteditDL_gain: parseFloat(v_gain_dl),
												noteditUL_maxpwr: parseFloat(v_maxpwr_ul),
												noteditDL_maxpwr: parseFloat(v_maxpwr_dl)
									 		  });
									   
									  		 tabla_dpx.push({	
												Band:itempsunit.nomband,												
												dpxlowstart: parseFloat(itempsunit.fstartdl),
												dpxlowstop:  parseFloat(itempsunit.fstopdl),
												dpxhighstart: parseFloat(itempsunit.fstartul),
												dpxhighstop: parseFloat(itempsunit.fstopul),
												dpxlowstartcustom:parseFloat(itempsunit.fstartdl),
												dpxlowstopcustom:   parseFloat(itempsunit.fstopdl),
												dpxhighstartcustom:parseFloat(itempsunit.fstartul),
												dpxhighstopcustom: parseFloat(itempsunit.fstopul),
												 });
											}
											else
											{
												tabla_gain_dlul.push({	
												Band:itempsunit.nomband,
												hiddengainudstart: parseFloat(itempsunit.fstartdl),
												hiddengainudstop: parseFloat(itempsunit.fstopdl),
												hiddengainulstart: parseFloat(itempsunit.fstartul),
												hiddengainulstop: parseFloat(itempsunit.fstopul), 
												DL_Start: parseFloat(0),
												DL_Stop: parseFloat(0),
												UL_Start: parseFloat(0),
												UL_Stop: parseFloat(0), 
												noteditUL_gain: parseFloat(v_gain_ul),
												noteditDL_gain: parseFloat(v_gain_dl),
												noteditUL_maxpwr: parseFloat(v_maxpwr_ul),
												noteditDL_maxpwr: parseFloat(v_maxpwr_dl)
									 		  });
									   
									  		 tabla_dpx.push({	
												Band:itempsunit.nomband,												
												dpxlowstart: parseFloat(itempsunit.fstartdl),
												dpxlowstop:  parseFloat(itempsunit.fstopdl),
												dpxhighstart: parseFloat(itempsunit.fstartul),
												dpxhighstop: parseFloat(itempsunit.fstopul),
												dpxlowstartcustom:0,
												dpxlowstopcustom:  0,
												dpxhighstartcustom: 0,
												dpxhighstopcustom: 0
												 });
											}

											
									   
									});
									
						   
								tabla_gain_udul2dagen();
								 list_tabla_dpx_udul2dagen();
								/* $('#txtdescripso').css('background-color', '#aabbcc');
								 $('#txtnotepo').css('background-color', '#aabbcc');
								 $('#txtchudstart').css('background-color', '#aabbcc');
								 $('#txtchudstop').css('background-color', '#aabbcc');
								 $('#txtchulstart').css('background-color', '#aabbcc');
								 $('#txtchulstop').css('background-color', '#aabbcc');
								 
								 $('#txtdpxlowstart').css('background-color', '#aabbcc');
								 $('#txtdpxlowstop').css('background-color', '#aabbcc');
								 $('#txtdpxhighstart').css('background-color', '#aabbcc');
								 $('#txtdpxhighstop').css('background-color', '#aabbcc');
								 
								 $('#txtnotedpc').css('background-color', '#aabbcc');
								 
								  $('#txtchul').css('background-color', '#aabbcc');
								 $('#txtchud').css('background-color', '#aabbcc');
								 $('#txtnotechanel').css('background-color', '#aabbcc');
								  $('#txtdescripmatesp').css('background-color', '#aabbcc');
								  */
								 
						/// deshabilitamos		
					/* temportal por lea
						
								  $('#txtdescripso').prop('disabled', true);
								 $('#txtnotepo').prop('disabled', true);
								 $('#txtchudstart').prop('disabled', true);
								 $('#txtchudstop').prop('disabled', true);
								 $('#txtchulstart').prop('disabled', true);
								 $('#txtchulstop').prop('disabled', true);
								 
								 $('#txtdpxlowstart').prop('disabled', true);
								 $('#txtdpxlowstop').prop('disabled', true);
								 $('#txtdpxhighstart').prop('disabled', true);
								 $('#txtdpxhighstop').prop('disabled', true);
								 
								 $('#txtnotedpc').prop('disabled', true);
								 
								  $('#txtchul').prop('disabled', true);
								 $('#txtchud').prop('disabled', true);
								 $('#txtnotechanel').prop('disabled', true);
								  $('#txtdescripmatesp').prop('disabled', true);
								  
								   $('#txtpwrsupply').prop('disabled', true);
								    $('#txtdlgain').prop('disabled', true);
									 $('#txtulgain').prop('disabled', true);
									  $('#txtdlmaxpwr').prop('disabled', true);
									   $('#txtulmaxpwr').prop('disabled', true);
								  
								  
								 */ 
								  
								
							 // $('#generalinfopo').html(tabla_info_show_po); 
									
						}
						
						
					}
				});				
				
				
			});
			
		 // AutoComplete de CUIS version TOP

$('#txtlistcius').select2({
 ajax: {
    url: "ajax_list_cuis.php",
    dataType: 'json',
    delay: 2,
    data: function (params) {
      return {
        q: params.term, // search term
        page: params.page
      };
    },
    processResults: function (data) {
      // Transforms the top-level key of the response object from 'items' to 'results'
      return {
        results: data.items
      };    
    },
    cache: false
  },
  placeholder: 'Search CIU',
  minimumInputLength: 1 ,
  templateResult: formatRepo,
  templateSelection: formatRepoSelection
});

// fin// AutoComplete de CUIS version TOP

		   //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()
		
		//Inicio mostrar hora live
		 var interval = setInterval(function() {
			 
        var momentNow = moment();
		var newYork    = momentNow.tz('America/New_York').format('ha z');
          $('#date-part').html(momentNow.format('YYYY-MM-DD') 	  );
        $('#time-part').html(momentNow.format('hh:mm:ss'));
			$('#dyhya').val(momentNow.format('YYYY-MM-DD')+' '+ momentNow.format('hh:mm:ss'));
		}, 100);
		//FIN mostrar hora live
			console.log( "ready!" );
		

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
                inactivityWait: 100000,
                dialogWait: 10,
                logoutUrl: 'logout.php'
            })
	// fin controlar inactividad en la web		
	
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
			
			tabla_gain_udul2dagen();
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
			
			
			list_tabla_dpx_udul2dagen();
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
				 
				 console.log(html);
				 	$('#listacium').html(html);
		 
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
	
	function  list_tabla_dpx_udul2dagen()
		{
		var jname ="";
		var v_temp_dpx="";

		var htmlmejoradodpx='	<table class="table table-striped table-bordered table-sm"><thead >    <tr ><th class="table-dark text-center" scope="col">#</th> <th class="table-primary text-center" colspan=2 scope="col">LOW </th><th  class="table-info text-center" colspan=2 scope="col">HIGH </th> </tr>';
		htmlmejoradodpx += '<tr> <th width="100px"  class="table-dark text-center"  style="width: 10px">Band</th> <th  class="table-primary text-center" >DPX Low Start </th> <th  class="table-primary text-center" >DPX Low Stop </th><th  class="table-info text-center" >DPX High Start </th><th  class="table-info text-center" >DPX High Stop </th> </tr> </thead> <tbody>';
			
			for( var i = 0; i < tabla_dpx.length; i++) 
			{
				console.log(tabla_dpx[0]);
				var v_temp_DL_Start='';
				var v_temp_DL_Startclass='';

			
				if (tabla_dpx[i].Band.indexOf('700') >=0 || tabla_dpx[i].Band.indexOf('800')>=0)	
				{
					htmlmejoradodpx += '<tr><th width="100px" scope="row">'+tabla_dpx[i].Band+'</th>	<td  width="150px" class=" text-center  id'+i+'#dpxhighstart'+'" id="id'+i+'#dpxhighstart" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#dpxhighstart'+"'"+','+i+')" >'+tabla_dpx[i].dpxhighstartcustom+' MHz</td>	<td width="150px" class=" text-center  id'+i+'#dpxhighstop'+'" id="id'+i+'#dpxhighstop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#dpxhighstop'+"'"+','+i+')" >'+tabla_dpx[i].dpxhighstopcustom+' MHz</td>';
					htmlmejoradodpx += '<td  width="150px" class=" text-center  id'+i+'#dpxlowstart'+'" id="id'+i+'#dpxlowstart" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#dpxlowstart'+"'"+','+i+')" >'+tabla_dpx[i].dpxlowstartcustom+' MHz</td>	<td width="150px" class=" text-center  id'+i+'#dpxlowstop'+'" id="id'+i+'#dpxlowstop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#dpxlowstop'+"'"+','+i+')" >'+tabla_dpx[i].dpxlowstopcustom+' MHz</td>';
				
				}
				else
				{
					v_temp_dpxlowstartcustom='';
					v_temp_dpxlowstartcustomclass='colorfondonaranja';
					if (tabla_dpx[i].dpxlowstartcustom!=0)
						{
							v_temp_dpxlowstartcustom=tabla_dpx[i].dpxlowstartcustom + ' MHz';
							v_temp_dpxlowstartcustomclass='';
						}
						v_temp_dpxlowstopcustom='';
					v_temp_dpxlowstopcustomomclass='colorfondonaranja';
					if (tabla_dpx[i].dpxlowstopcustom!=0)
						{
							v_temp_dpxlowstopcustom=tabla_dpx[i].dpxlowstopcustom + ' MHz';
							v_temp_dpxlowstopcustomomclass='';
						}

						v_temp_dpxhighstartcustom='';
					v_temp_dpxhighstartcustomclass='colorfondonaranja';
					if (tabla_dpx[i].dpxhighstartcustom!=0)
						{
							v_temp_dpxhighstartcustom=tabla_dpx[i].dpxhighstartcustom + ' MHz';
							v_temp_dpxhighstartcustomclass='';
						}

						v_temp_dpxhighstopcustom='';
					v_temp_dpxhighstopcustomclass='colorfondonaranja';
					if (tabla_dpx[i].dpxhighstopcustom!=0)
						{
							v_temp_dpxhighstopcustom=tabla_dpx[i].dpxhighstopcustom + ' MHz';
							v_temp_dpxhighstopcustomclass='';
						}


					htmlmejoradodpx += '<tr><th width="100px" scope="row">'+tabla_dpx[i].Band+'</th><td  width="150px"  contenteditable="true" class=" text-center '+v_temp_dpxlowstartcustomclass+'  id'+i+'#dpxlowstartcustom'+'" id="id'+i+'#dpxlowstartcustom" onkeypress="return soloNumeros(event)"  onblur="modif_table_arraydpx('+"'id"+i+'#dpxlowstartcustom'+"'"+','+i+')" >'+v_temp_dpxlowstartcustom+' </td><td width="150px"   contenteditable="true" class=" text-center '+v_temp_dpxlowstopcustomomclass+'  id'+i+'#dpxlowstopcustom'+'" id="id'+i+'#dpxlowstopcustom" onkeypress="return soloNumeros(event)"  onblur="modif_table_arraydpx('+"'id"+i+'#dpxlowstopcustom'+"'"+','+i+')" >'+v_temp_dpxlowstopcustom+' </td>';
					htmlmejoradodpx += '<td  width="150px" contenteditable="true" class=" text-center '+v_temp_dpxhighstartcustomclass+'  id'+i+'#dpxhighstartcustom'+'" id="id'+i+'#dpxhighstartcustom" onkeypress="return soloNumeros(event)"  onblur="modif_table_arraydpx('+"'id"+i+'#dpxhighstartcustom'+"'"+','+i+')" >'+v_temp_dpxhighstartcustom+' </td><td width="150px"  contenteditable="true" class=" text-center '+v_temp_dpxhighstopcustomclass+'  id'+i+'#dpxhighstopcustom'+'" id="id'+i+'#dpxhighstopcustom" onkeypress="return soloNumeros(event)"  onblur="modif_table_arraydpx('+"'id"+i+'#dpxhighstopcustom'+"'"+','+i+')" >'+v_temp_dpxhighstopcustom+' </td>';
				/*
					dpxlowstart: parseFloat(v_txtdpxlowstart),
									dpxlowstop:  parseFloat(v_txtdpxlowstop),
									dpxhighstart: parseFloat(v_txtdpxhighstart),
									dpxhighstop: parseFloat(v_txtdpxhighstop),
									dpxlowstartcustom:0,
									dpxlowstopcustom:  0,
									dpxhighstartcustom: 0,
									dpxhighstopcustom: 0
									*/
				
				/*	htmlmejoradodpx += '<tr><th width="100px" scope="row">'+tabla_gain_dlul[i].Band+'</th>	<td  width="150px" class=" text-center '+v_temp_DL_Startclass+' id'+i+'#DL_Start'+'" id="id'+i+'#DL_Start" onkeypress="return soloNumeros(event)"  onblur="modif_table_arraydpx('+"'id"+i+'#DL_Start'+"'"+','+i+')"  contenteditable="true">'+v_temp_DL_Start+' MHz</td>	<td width="150px" class=" text-center '+v_temp_DL_Stopclass+' id'+i+'#DL_Stop'+'" id="id'+i+'#DL_Stop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#DL_Stop'+"'"+','+i+')"  contenteditable="true">'+v_temp_DL_Stop+' MHz</td><td class=" text-center" >'+tabla_gain_dlul[i].noteditDL_gain+' dB </td><td class=" text-center" >'+tabla_gain_dlul[i].noteditDL_maxpwr+' dBm</td>';
					htmlmejoradodpx += '<td  width="150px" class=" text-center '+v_temp_Startclass+' id'+i+'#UL_Start'+'" id="id'+i+'#UL_Start" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#UL_Start'+"'"+','+i+')"  contenteditable="true">'+v_temp_Start+' MHz</td><td width="150px" class=" text-center '+v_temp_UL_Stopclass+' id'+i+'#UL_Stop'+'" id="id'+i+'#UL_Stop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#UL_Stop'+"'"+','+i+')"  contenteditable="true">'+v_temp_UL_Stop+' MHz</td><td  class=" text-center">'+tabla_gain_dlul[i].noteditUL_gain+' dB</td>';
					htmlmejoradodpx += ' <td  class=" text-center" >'+tabla_gain_dlul[i].noteditUL_maxpwr+' dBm </td> <th scope="row"> <a href="#" onclick="borrar_array_uldl('+i+')"> <i class="fas fa-trash-alt"></i> Del</a> </th> </tr>';
					*/
				}			
			
			}
		htmlmejoradodpx += ' </tbody></table>'
			var html = '<table class="table  table-striped table-sm ">';
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
					 
						if ( 'UNKNOW' == tabla_dpx[i][j] )
						{
							html += '<td>' + tabla_dpx[i][j]  +' </td>';	  
						}
						else
						{
							if (j =='Band')
								{
									html += '<td>' + tabla_dpx[i][j]  +' </td>';	  
								}
								else
								{
									html += '<td>' + tabla_dpx[i][j]  +' MHz</td>';	    
								} 
						}
						///html += '<td>' + tabla_dpx[i][j]  +' MHz</td>';	  
						v_temp_dpx = v_temp_dpx  + tabla_dpx[i][j] + "|"
					
					
				  }
				  html += '<td>  <a href="#" onclick="borrar_array_dpx('+i+')"> <i class="fas fa-trash-alt"></i> Del</a> </td>';	  
				  html += '</tr>';
				 }
				 html += '</table>';
				 v_temp_dpx = v_temp_dpx + "#";  
				 console.log(v_temp_dpx);
				 /// variable html no usar mas es html viejoo
				 	///$('#listadpx').html(html+'<br><br>'+htmlmejoradodpx);
					 $('#listadpx').html(htmlmejoradodpx);
					$('#templistadpx').val(v_temp_dpx);
	}
	
	function list_tabla_dpx()
	{
	var jname ="";
	/*	var v_temp_dpx="";
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
					*/
	}
	
	function tabla_gain_udul()
	{
	/*	var jname ="";
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
					 
					if (j =='Band')
						{
							html += '<td>' + tabla_gain_dlul[i][j]  +' </td>';	  
						}
						else
						{
							html += '<td>' + tabla_gain_dlul[i][j]  +' MHz</td>';	  
						}
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
				
		*/
	}

	
	function tabla_gain_udul2dagen()
	{
		var jname ="";
		var v_templistchannel="";
		var esUHFVHF=0;
		var htmlmejorado='	<table class="table table-striped table-bordered table-sm"><thead >    <tr ><th class="table-dark text-center" scope="col">#</th> <th class="table-primary text-center" colspan=4 scope="col">DOWNLINK </th><th  class="table-info text-center" colspan=4 scope="col">UPLINK</th> </tr>';
		htmlmejorado += '<tr> <th width="100px"  class="table-dark text-center"  style="width: 10px">Band</th> <th  class="table-primary text-center" >Start </th> <th  class="table-primary text-center" >Stop </th><th  class="table-primary text-center" >Gain </th><th  class="table-primary text-center" >Max Pwr</th> <th  class="table-info text-center">Start </th><th  class="table-info text-center">Stop </th><th  class="table-info text-center">Gain </th> <th  class="table-info text-center">Max Pwr</th>  </thead> <tbody>';
		
		/// Buscamos 2 UHF
		var tiene2UHF =0;
		for( var im = 0; im < tabla_gain_dlul.length; im++) 
		{	
				if (tabla_gain_dlul[im].Band.indexOf('UHF')>=0)
				{
					tiene2UHF =tiene2UHF + 1;
				}
		}

		for( var i = 0; i < tabla_gain_dlul.length; i++) 
		{
			console.log(tabla_gain_dlul[0]);
			var v_temp_DL_Start='';
			var v_temp_DL_Startclass='';

			if (tabla_gain_dlul[i].DL_Start==0)
			{
				v_temp_DL_Start='';
				v_temp_DL_Startclass='colorfondonaranja';
			}
			else
			{
				v_temp_DL_Start=tabla_gain_dlul[i].DL_Start+ ' MHz';
				v_temp_DL_Startclass='';
			}

			var v_temp_DL_Stopclass= ''
			var v_temp_DL_Stop='';
			if (tabla_gain_dlul[i].DL_Stop==0)
			{
				v_temp_DL_Stop='';
				v_temp_DL_Stopclass='colorfondonaranja';
			}
			else
			{
				v_temp_DL_Stop=tabla_gain_dlul[i].DL_Stop + ' MHz';
				v_temp_DL_Stopclass='';
			}

			var v_temp_UL_Stopclass= ''
			var v_temp_UL_Stop='';
			if (tabla_gain_dlul[i].UL_Stop==0)
			{
				v_temp_UL_Stop='';
				v_temp_UL_Stopclass='colorfondonaranja';
			}
			else
			{
				v_temp_UL_Stop=tabla_gain_dlul[i].UL_Stop + ' MHz';
				v_temp_UL_Stopclass='';
			}

			var v_temp_Startclass= ''
			var v_temp_Start='';
			if (tabla_gain_dlul[i].UL_Start==0)
			{
				v_temp_Start='';
				v_temp_Startclass='colorfondonaranja';
			}
			else
			{
				v_temp_Start=tabla_gain_dlul[i].UL_Start + ' MHz';
				v_temp_Startclass='';
			}
console.log('a'+ tabla_gain_dlul[i].Band.indexOf('700') );
console.log('b'+ tabla_gain_dlul[i].Band.indexOf('800'));
			if (tabla_gain_dlul[i].Band.indexOf('700') >=0 || tabla_gain_dlul[i].Band.indexOf('800')>=0)	
			{
				htmlmejorado += '<tr><th width="100px" scope="row">'+tabla_gain_dlul[i].Band+'</th>	<td  width="150px" class=" text-center  id'+i+'#DL_Start'+'" id="id'+i+'#DL_Start" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#DL_Start'+"'"+','+i+')" >'+tabla_gain_dlul[i].hiddengainudstart+' </td>	<td width="150px" class=" text-center  id'+i+'#DL_Stop'+'" id="id'+i+'#DL_Stop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#DL_Stop'+"'"+','+i+')" >'+tabla_gain_dlul[i].hiddengainudstop+' </td><td class=" text-center" >'+tabla_gain_dlul[i].noteditDL_gain+' dB </td><td class=" text-center" >'+tabla_gain_dlul[i].noteditDL_maxpwr+' dBm</td>';
				htmlmejorado += '<td  width="150px" class=" text-center  id'+i+'#UL_Start'+'" id="id'+i+'#UL_Start" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#UL_Start'+"'"+','+i+')"  >'+tabla_gain_dlul[i].hiddengainulstart+' </td><td width="150px" class=" text-center  id'+i+'#UL_Stop'+'" id="id'+i+'#UL_Stop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#UL_Stop'+"'"+','+i+')" >'+tabla_gain_dlul[i].hiddengainulstop+' </td><td  class=" text-center">'+tabla_gain_dlul[i].noteditUL_gain+' dB</td>';
				htmlmejorado += ' <td  class=" text-center" >'+tabla_gain_dlul[i].noteditUL_maxpwr+' dBm </td> ';
			
			}
			else
			{
				if (esUHFVHF==0 ||esUHFVHF==2)
				{
 					console.log('esUHFVHF:'+esUHFVHF+ '--buscamos:' +tiene2UHF);
					var nombandper='';
					if (tiene2UHF==2)
					 {
						nombandper = 'UHF FULL'; 
						///cargar en el array.. lo datos..UHF FULL
			         }
			 		 else
					 {
						nombandper = tabla_gain_dlul[i].Band;             
				 	 }

				htmlmejorado += '<tr><th width="100px" scope="row">'+nombandper +'</th>	<td  width="150px" class=" text-center '+v_temp_DL_Startclass+' id'+i+'#DL_Start'+'" id="id'+i+'#DL_Start" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#DL_Start'+"'"+','+i+')"  contenteditable="true">'+v_temp_DL_Start+' </td>	<td width="150px" class=" text-center '+v_temp_DL_Stopclass+' id'+i+'#DL_Stop'+'" id="id'+i+'#DL_Stop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#DL_Stop'+"'"+','+i+')"  contenteditable="true">'+v_temp_DL_Stop+' </td><td class=" text-center" >'+tabla_gain_dlul[i].noteditDL_gain+' dB </td><td class=" text-center" >'+tabla_gain_dlul[i].noteditDL_maxpwr+' dBm</td>';
				htmlmejorado += '<td  width="150px" class=" text-center '+v_temp_Startclass+' id'+i+'#UL_Start'+'" id="id'+i+'#UL_Start" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#UL_Start'+"'"+','+i+')"  contenteditable="true">'+v_temp_Start+' </td><td width="150px" class=" text-center '+v_temp_UL_Stopclass+' id'+i+'#UL_Stop'+'" id="id'+i+'#UL_Stop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#UL_Stop'+"'"+','+i+')"  contenteditable="true">'+v_temp_UL_Stop+' </td><td  class=" text-center">'+tabla_gain_dlul[i].noteditUL_gain+' dB</td>';
				htmlmejorado += ' <td  class=" text-center" >'+tabla_gain_dlul[i].noteditUL_maxpwr+' dBm </td> ';
				}
			}
		
			/// Validamos UHF VHF
					if (tabla_gain_dlul[i].Band.indexOf('UHF')>=0)
						{
							esUHFVHF=esUHFVHF+1;	
						}
						if (tabla_gain_dlul[i].Band.indexOf('VHF')>=0)
						{
							esUHFVHF=1;	
						}
		}
		htmlmejorado += ' </tbody></table><P style="color:rgba(250, 5, 5)";>* <b>The cell that contains this color indicates missing information.</b></P> '
	
				var html = '<table class="table  table-striped table-sm ">';
				 html += '<tr>';
				 var cantcabez = tabla_gain_dlul[0];

				 for( var j in  cantcabez) {
					 
					 jname= j
					 if (j=='DL_Start')
					 {
						 jname='DL Start';
					 }
					 if (j=='DL_Stop')
					 {
						 jname='DL Stop';
					 }
					 if (j=='UL_Start')
					 {
						 jname='UL Start';
					 }
					 if (j=='UL_Stop')
					 {
						 jname='UL Stop';
					 }
					
					 if (!jname.indexOf('hidden'))
					 {
					///	html += '<th>s' + jname.replace('notedit','') + '</th>';
					 }
					 else
					 {
						html += '<th>' + jname.replace('notedit','').replace('_',' ') + '</th>';
					 }
					
				  
				
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
					 
					 if ( 'UNKNOW' == tabla_gain_dlul[i][j] )
					 {
						 html += '<td>' + tabla_gain_dlul[i][j]  +' </td>';	   
					 }
				     else
					 {
					  /// html += '<td>' + tabla_gain_dlul[i][j]  +' MHz</td>';	   
					   if (j =='Band')
						{
							html += '<td>' + tabla_gain_dlul[i][j]  +' </td>';	  
						}
						else
						{
							if (!j.indexOf('hidden'))
							{
							//	html += '<td contenteditable="true"> sss ' + tabla_gain_dlul[i][j]  +' MHz</td>';	  
							}
							else
							{
								if (j.indexOf('notedit'))
								{
									if (tabla_gain_dlul[i][j]==0)
									{
										html += '<td width="150px" contenteditable="true" id="id'+i+'#'+j+'" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#'+j+"'"+','+i+')" class=" colorfondonaranja id'+i+'#'+j+'"> -missing info -</td>';	  
									}
									else
									{
										html += '<td width="150px" contenteditable="true" id="id'+i+'#'+j+'" onkeypress="return soloNumeros(event)" class="id'+i+'#'+j+'" onblur="modif_table_array('+"'id"+i+'#'+j+"'"+','+i+')">  ' + tabla_gain_dlul[i][j]  +' MHz</td>';	  
									}
								
								}
								else
								{
									html += '<td > ' + tabla_gain_dlul[i][j]  +' </td>';	  
								}
							
							}
							
						}
					 }	 
						
						v_templistchannel = v_templistchannel  + tabla_gain_dlul[i][j] + "|"
					
					
				  }
				  html += '<td>  <a href="#" onclick="borrar_array_uldl('+i+')"> <i class="fas fa-trash-alt"></i> Del</a> </td>';	  
				  html += '</tr>';
				 }
				 html += '</table>';
				 //no usar la variable html.. es html viejo
				 v_templistchannel = v_templistchannel + "#";  
				 console.log(v_templistchannel);
				 ///	$('#listagainuldl').html(html+'<br><br>'+htmlmejorado);
					 $('#listagainuldl').html(htmlmejorado);
					$('#templistagainuldl').val(v_templistchannel);
				
		
	}

	function modif_table_arraydpx (lacelda, valorcelda)
	{
		var losdatosaupatar = lacelda.split("#");

		///document.getElementsByClassName("id0#DL_Start")[0].innerHTML;
		var aaaobte = document.getElementsByClassName(lacelda)[0].innerHTML;
		var aaapbtelimpio = aaaobte.replace('MHz','');
		if ($.isNumeric( aaapbtelimpio) )
		{

			console.log(	tabla_dpx[valorcelda].dpxhighstart);
			console.log(	tabla_dpx[valorcelda].dpxhighstop);

			console.log(	tabla_dpx[valorcelda].dpxlowstart);
			console.log(	tabla_dpx[valorcelda].dpxlowstop);
			
		
		
			if ( losdatosaupatar[1] =='dpxhighstartcustom' || losdatosaupatar[1] =='dpxhighstopcustom')
			{
				if ( parseFloat (tabla_dpx[valorcelda].dpxhighstart) <= parseFloat(aaapbtelimpio) && parseFloat (tabla_dpx[valorcelda].dpxhighstop) >= parseFloat(aaapbtelimpio) )
				{
					tabla_dpx[valorcelda][losdatosaupatar[1]]=aaapbtelimpio;
				}
				else
				{
					alert('HIGH::out of range');
				}
			}
			if ( losdatosaupatar[1] =='dpxlowstartcustom' || losdatosaupatar[1] =='dpxlowstopcustom')
			{
				if ( parseFloat (tabla_dpx[valorcelda].dpxlowstart) <= parseFloat(aaapbtelimpio) && parseFloat (tabla_dpx[valorcelda].dpxlowstop) >= parseFloat(aaapbtelimpio) )
				{
					tabla_dpx[valorcelda][losdatosaupatar[1]]=aaapbtelimpio;
				}
				else
				{
					alert('LOW::out of range');
				}
			}

			
		///	tabla_dpx[valorcelda][losdatosaupatar[1]]=aaapbtelimpio;	

		}
		console.log(aaaobte);
		console.log(valorcelda);
		console.log(losdatosaupatar[1]);

	
		list_tabla_dpx_udul2dagen();

	}
	function modif_table_array(lacelda, valorcelda)
	{
		var losdatosaupatar = lacelda.split("#");

		///document.getElementsByClassName("id0#DL_Start")[0].innerHTML;
		var aaaobte = document.getElementsByClassName(lacelda)[0].innerHTML;
		var aaapbtelimpio = aaaobte.replace('MHz','');
		if ($.isNumeric( aaapbtelimpio) )
		{

		/*	console.log(	tabla_gain_dlul[valorcelda].hiddengainudstart);
			console.log(	tabla_gain_dlul[valorcelda].hiddengainudstop);

			console.log(	tabla_gain_dlul[valorcelda].hiddengainulstart);
			console.log(	tabla_gain_dlul[valorcelda].hiddengainulstop);
			*/
			/*
			if ( losdatosaupatar[1] =='DL_Start' || losdatosaupatar[1] =='DL_Stop')
			{
				if ( parseFloat (tabla_gain_dlul[valorcelda].hiddengainudstart) <= parseFloat(aaapbtelimpio) && parseFloat (tabla_gain_dlul[valorcelda].hiddengainudstop) >= parseFloat(aaapbtelimpio) )
				{
					tabla_gain_dlul[valorcelda][losdatosaupatar[1]]=aaapbtelimpio;
				}
				else
				{
					alert('DL::out of range');
				}
			}
			if ( losdatosaupatar[1] =='UL_Start' || losdatosaupatar[1] =='UL_Stop')
			{
				if ( parseFloat (tabla_gain_dlul[valorcelda].hiddengainulstart) <= parseFloat(aaapbtelimpio) && parseFloat (tabla_gain_dlul[valorcelda].hiddengainulstop) >= parseFloat(aaapbtelimpio) )
				{
					tabla_gain_dlul[valorcelda][losdatosaupatar[1]]=aaapbtelimpio;	
				}
				else
				{
					alert('UL::out of range');
				}
			}
			*/

			
			tabla_gain_dlul[valorcelda][losdatosaupatar[1]]=aaapbtelimpio;	

		}
		console.log(aaaobte);
		console.log(valorcelda);
		console.log(losdatosaupatar[1]);

	
		tabla_gain_udul2dagen();

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
								Band: 'UNKNOW' ,							   
									dpxlowstart: parseFloat(v_txtdpxlowstart),
									dpxlowstop:  parseFloat(v_txtdpxlowstop),
									dpxhighstart: parseFloat(v_txtdpxhighstart),
									dpxhighstop: parseFloat(v_txtdpxhighstop),
									dpxlowstartcustom:0,
									dpxlowstopcustom:  0,
									dpxhighstartcustom: 0,
									dpxhighstopcustom: 0
						   });
						//   list_tabla_dpx();
						   list_tabla_dpx_udul2dagen();
						   
						    
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

		var v_gain_ul = parseFloat($('#txtulgain').val());
		var v_gain_dl = parseFloat($('#txtdlgain').val());
		var v_maxpwr_ul = parseFloat($('#txtulmaxpwr').val());
		var v_maxpwr_dl = parseFloat($('#txtdlmaxpwr').val());
		
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
									Band: 'UNKNOW' ,						   
									hidgainudstart: parseFloat(v_txtchudstart),
									hidgainudstop: parseFloat(v_txtchudstop),
									hidgainulstart: parseFloat(v_txtchulstart),
									hidgainulstop: parseFloat(v_txtchulstop),
									UL_gain: parseFloat(v_gain_ul),
									DL_gain: parseFloat(v_gain_dl),
									UL_maxpwr: parseFloat(v_maxpwr_ul),
									DL_maxpwr: parseFloat(v_maxpwr_dl)

						   });
						   
						 				   
						   
						//   tabla_gain_udul();
						   tabla_gain_udul2dagen();
						   
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
	
	function list_po_by_customer_andpo(idnropo)
	{
		var temp = '';
		 $.ajax
				({ 
					url: 'ajax_list_pobycutomers.php',
					data: "idcust="+ $("#txtlistcustomers").val(),	
					type: 'post',				
					datatype:'JSON', 
					async: false,					
					success: function(data)
					{
						
						$.each(data, function(i) {
						   console.log(data[i]);
						   $.each(data[i], function(io) {
								//console.log(data[i][io].id);
								if (data[i][io].id ==  $("#txtponumber").val())
								{
									if (temp != data[i][io].text2 )
									{
										temp = data[i][io].text2;
										$("#txtsonumberlu").append('<option value='+data[i][io].text2+'>'+data[i][io].text2+'</option>');
									}
									
								}
								///$("#txtponumber").append('<option value='+data[i][io].id+'>'+data[i][io].id+'</option>');
									
							});
						 });
						 // lleno combo cliente
					}
				});
		
	}
	
	function list_po_by_customer(idcustomers)
	{
		var temp2 = '';
		 $.ajax
				({ 
					url: 'ajax_list_pobycutomers.php',
					data: "idcust="+ idcustomers,	
					type: 'post',				
					datatype:'JSON', 
					async: false,					
					success: function(data)
					{
						
						$.each(data, function(i) {
						   console.log(data[i]);
						   $.each(data[i], function(io) {
								console.log(data[i][io].id);
								
								if (temp != data[i][io].id )
									{
										temp = data[i][io].id;
								$("#txtponumber").append('<option value='+data[i][io].id+'>'+data[i][io].id+'</option>');
									}
								//	$("#txtsonumberlu").append('<option value='+data[i][io].id+'>'+data[i][io].text2+'</option>');
							});
						 });
						 // lleno combo cliente
					}
					
				});
				
	}
	
	
	function chequearso_usado(nrosoasgin)
	{
		//alert(nropo);
		if ($("#txtponumber").val() != '')
		{
			//
			var visrma =  $("#txtsonumberlu").val().toUpperCase().search("RM");
			if (visrma <0)
			{

			
				 $.ajax
				({ 
					url: 'ajax_list_sobycutomers.php',
					data: "idcust="+ $("#txtlistcustomers").val()+"&nroso="+nrosoasgin,	
					type: 'post',				
					datatype:'JSON', 
					async: false,					
					success: function(data)
					{
						
						$.each(data, function(i) {
						   //console.log(data[i].length);
						   if (data[i].length> 0)
						   {
//alert('SO associated ');
					   	  //  $("#txtsonumberlu").val('');
						   }
						   
						 });
					}
				});
			}
			else
			{
				alert('RMA products must be managed from the SALE ORDERS page.');
				$("#txtsonumberlu").val('');
			}
		}
		else
		{

			var visrma =  $("#txtsonumberlu").val().toUpperCase().search("RM");
			if (visrma >0)
			{
				$("#txtsonumberlu").val('');
			}

			 alert("PO: it can't be empty");
			  $("#txtponumber").focus();
		}
	
	}
	
	function chequearpootrocliente(nropo)
	{
		//alert(nropo);
		if ($("#txtlistcustomers").val() != '')
		{
				 $.ajax
				({ 
					url: 'ajax_list_pobycutomers.php',
					data: "idcust="+ $("#txtlistcustomers").val()+"&nropo="+nropo,	
					type: 'post',				
					datatype:'JSON', 
					async: false,					
					success: function(data)
					{
						
						$.each(data, function(i) {
						   //console.log(data[i].length);
						   if (data[i].length> 0)
						   {
							  // alert('PO associated with another customer');
						//  $("#txtponumber").val('');
						   }
						   
						 });
					}
				});
		}
	
	}
	
	function importar_nowl()
	{
		$("#importador").addClass('d-none');
		var tempchdl ='';
		var tempchul ='';
		tempchdl = $("#importchdl").val().split('\n');
		tempchul = $("#importchul").val().split('\n');
		if (tempchdl.length == tempchul.length)
		{
			for (i = 0; i < tempchdl.length; i++) {
					///Agrego canales.
					if (  tempchdl[i] !='')
					{
						tabla_channel_quantity.push({						
							channeldl: tempchdl[i],
							channelul: tempchul[i]					
							});
					}
					
				}
				$("#importchdl").val('');
				$("#importchul").val('');
							tabla_channels();


		}
	}
	
	function importar_channell()
	{
		$("#importador").removeClass('d-none');
	}

	function add_cui_SO()
	{
		 // $('#idtxtlistcustomers').val('');
		 // $('#txtcant').val('');
		///	 idtxtlistcius txtlistcius
		var v_idtxtlistcius = $('#idtxtlistcius').val();
		var v_txtcuicant = $('#txtcant').val();
		
		  if (v_idtxtlistcius=="")
		  {
				
		  }
		  else
		  {
			 if ( eval(v_txtcuicant)>0 )
			 {
				//  $('#txtcuicant').val( $('#idtxtlistcius').val() + '#'+  $('#txtcant').val());
				//  tabla_cui_cant
				//  tabla_cui_cant.includes( $('#txtlistcius').val()  ); 
				var v_loencontre = 0;
					
//				tabla_cui_cant.length
					 $.each(tabla_cui_cant, function (i, value) {
						if (value.namecui == $('#txtlistcius').val())
						{
							// Lo encontre actualizo datos.
							v_loencontre = 1;
							tabla_cui_cant[i].cant = eval($('#txtcant').val()) + eval(tabla_cui_cant[i].cant); 
						}
						console.log ("aaaaa" + i + '-' + value.idcui+ '--'+ value.namecui);
					}); 
					if ( v_loencontre == 0)
					{
						  tabla_cui_cant.push({						
						namecui: $('#txtlistcius').val() ,
						cant: $('#txtcant').val(),
						idcui: $('#idtxtlistcius').val() 
					});
					}
				 
   
					var html = '<table class="table  table-striped table-sm ">';
				 html += '<tr>';
				 var cantcabez = tabla_cui_cant[0];
				 for( var j in  cantcabez) {
					 jname="";
					 if (j=='namecui')	
					 {
						 jname="CIU";
					 }	
					if (j=='cant')	
					 {
						 jname="Quantity";
					 }						 
					 
				  html += '<th>' + jname + '</th>';
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
				  html += '<td>  <a href="#" onclick="borrar_array('+i+')"> <i class="fas fa-trash-alt"></i> Del</a></td>';	  
				  html += '</tr>';
				 }
				 html += '</table>';
				 
			//	 console.log(html);
				 	$('#listacium').html(html);
					 
					 $('#idtxtlistcustomers').val('');
					$('#txtcant').val('');
					$('#txtlistcius').val('');
				
				
			 }
		  }
			  
	}
   
</script>

<link rel="stylesheet" href="css/validator_marco.css">
<script src="smoke/js/smoke.min.js"></script>
<script src="plugins/select2/js/select2.full.min.js"></script>

<script>
// just for the demos, avoids form submit

				
$("#btnchangep").click(function() {
	
	
	 if ( !$("#frmwo").hasClass("d-none" )  ) 
	 {
		 ///	$("#frmwo").addClass('d-none');
		// console.log('a ver');
		if( $('form').smkValidate() )
		{
			
			//if (tabla_channel_quantity.length >= 1 )
		//	{
			var xcantfaltantes = document.getElementsByClassName("colorfondonaranja");
				if (tabla_gain_dlul.length >= 1 && xcantfaltantes ==0 )	
				{
					
					$('#txtpwrsupply').prop('disabled', false);
								    $('#txtdlgain').prop('disabled', false);
									 $('#txtulgain').prop('disabled', false);
									  $('#txtdlmaxpwr').prop('disabled', false);
									   $('#txtulmaxpwr').prop('disabled', false);
									   
									   
					document.getElementById("myform").submit();
				}
				else
				{
					alert( "UNIT (DL - UL) List is required. ");	
				}
					//toastr["waiting"]("Wait....Sending presale information", "Attention :: PreSales ");
				//HACER POST	
				
				 
				  
	//			document.getElementById("myform").submit();
		//	}
		//	else
		//	{
		//		alert( "Channel List is required. ");	
		//	}
		
		}	
	 }
	 else
	 {
		////	alert('ojo');
									
								 $('#txtpwrsupply').prop('disabled', false);
								    $('#txtdlgain').prop('disabled', false);
									 $('#txtulgain').prop('disabled', false);
									  $('#txtdlmaxpwr').prop('disabled', false);
									   $('#txtulmaxpwr').prop('disabled', false); 
								  
						$("#txtdlgain").val(0);
					   $("#txtdlmaxpwr").val(0);
					    $("#txtulgain").val(0);
						 $("#txtulmaxpwr").val(0);
						 
		 document.getElementById("myform").submit();
	 }
		
	});
</script>


</html>

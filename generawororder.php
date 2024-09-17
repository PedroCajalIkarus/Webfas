<?php 

// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)

 include("db_conect.php"); 
	// error_reporting(E_ALL); 
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
		$v4 = $_REQUEST['txtpwrsupply']; //
		$vsaleordentmp = $_REQUEST['txtsonumber']; // txtsonumber		
		$v5 = $_REQUEST['txtrcgbwa']; ///$vidcustomer
		
		$vNuevoWO = $_REQUEST['txtnrowoingreso']; //  txtnrowoingreso
		
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
		
		//llevamos el array de IDBAND
		
		
		
			
		
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
					$typeregister="WO";
					$nrowoautogenrado = "000000000".$vmaxid."WO";
					$nrowoautogenrado =   substr($nrowoautogenrado, -10); 
						$nrowoautogenrado = trim($vNuevoWO);
						
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
					$sentencia->bindParam(':so_soft_external', $nrowoautogenrado);
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
						$typeregister="WO";
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="INSERT WO";
						$vdescripaudit="NEW REG WO".$vuserfas;
						$vtextaudit="INSERT INTO orders_sn(idorders, idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, idrev, idnroserie, so_soft_external, wo_serialnumber, idruninfo, ponumber, pwrsupplytype, rcgfbwa, moden_dig, date_approved, descripcion,	ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, nameapproved, notes, reqresources, typeregister, processday, processfasserver, so_original, so_associed) VALUES (:idorders, :idcustomers, :idfamilyprod, :idtypeband, :idtypeproduct, :idproduct, :idconfiguration, :idrev, :idnroserie, :so_soft_external, :wo_serialnumber, :idruninfo, :ponumber, :pwrsupplytype, :rcgfbwa, :moden_dig, :date_approved, :descripcion, :ul_gain, :ul_max_pwr, :dl_gain, :dl_max_pwr, :req_ppassy, :req_calibration, :req_spec, :req_other, :nameapproved, :notes, :reqresources, :typeregister, :processday, :processfasserver, :so_original, :so_associed?);";
						$vtextaudit=$vtextaudit."!!idorders:".$vmaxid;
						$vtextaudit=$vtextaudit."!!idcustomers:".$v0;
						$vtextaudit=$vtextaudit."!!idproduct:".$v1;
						$vtextaudit=$vtextaudit."!!ponumber:".$v3;
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
					 $vvidband =null;
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
									
									$vvidband =null;
								/*	foreach ($arr_idband as $key => $value) {
										//	echo $key . ":  " . $value['idband'] . "-" . $value['fstartul']. "-" . $value['fstopul']. "-" . $value['fstartdl']. "-" . $value['fstopdl'] . "<br>";
											if ( $value['fstartdl'] == $separa_DPX[1]  && $value['fstopdl'] == $separa_DPX[2] && $value['fstartul'] == $separa_DPX[3] && $value['fstopul'] == $separa_DPX[4])
											{
												$vvidband = $value['idband'];
											}
									}*/
									foreach ($arr_idband as $key => $value) {
										//	echo $key . ":  " . $value['idband'] . "-" . $value['fstartul']. "-" . $value['fstopul']. "-" . $value['fstartdl']. "-" . $value['fstopdl'] . "<br>";
											if ( $value['nombreband'] == $separa_DPX[0]  )
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
								$sentenciach->bindParam(':dpxlowstart', $separa_DPX[1]); //0
								$sentenciach->bindParam(':dpxlowstop', $separa_DPX[2]);
								$sentenciach->bindParam(':dpxhihgstart',$separa_DPX[3]);
								$sentenciach->bindParam(':dpxhihgstop', $separa_DPX[4]);
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
								$vtextaudit=$vtextaudit."!!dpxlowstart:".$separa_DPX[1]; //0
								$vtextaudit=$vtextaudit."!!dpxlowstop:".$separa_DPX[2];
								$vtextaudit=$vtextaudit."!!dpxhihgstart:".$separa_DPX[3];
								$vtextaudit=$vtextaudit."!!dpxhihgstop:".$separa_DPX[4];
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
					/* $porciones = explode("#", $varray_LISTUNIT);
					 $vidchunit=1;
					 $vtypedata="UNIT";
					   foreach($porciones as $elcanaluldl) {
							//echo "el canal:".$elcanaluldl;
							$separa_UNIT  = explode("|", $elcanaluldl);
							//echo "low".$separa_UNIT[0]."--".$separa_UNIT[1]."<br>";
							if ($elcanaluldl <> "")
							{
								// insetamos channel detalle PO
								
									$vvidband =null;
								
									foreach ($arr_idband as $key => $value) {
										//	echo $key . ":  " . $value['idband'] . "-" . $value['fstartul']. "-" . $value['fstopul']. "-" . $value['fstartdl']. "-" . $value['fstopdl'] . "<br>";
											if ( $value['nombreband'] == $separa_UNIT[0]  )
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
								$sentenciach->bindParam(':unitdlstart', $separa_UNIT[1]); // 0
								$sentenciach->bindParam(':unitdlstop', $separa_UNIT[2]);
								$sentenciach->bindParam(':unitulstart',$separa_UNIT[3]);
								$sentenciach->bindParam(':unitulstop', $separa_UNIT[4]);

								$sentenciach->bindParam(':ulgain', $v13); // 0
								$sentenciach->bindParam(':dlgain', $v15);
								$sentenciach->bindParam(':ulmaxpwr',$v14);
								$sentenciach->bindParam(':dlmaxpwr', $v16);

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
							
						}*/

						$sentenciach = $connect->prepare("insert into orders_sn_specs  SELECT idorders, idrev,   (0+ row_number() OVER ()) , 0, 'UNIT', 0, 0, 0, 0, 0, 0, v_unitdlstart, v_unitdlstop, v_unitulstart, v_unitulstop, '', idband, floor(v_ulgain), floor(v_dlgain), floor(v_ulmaxpwr), floor(v_dlmaxpwr)

						from 
						(
						
							select * 
							from ( 
	
						SELECT   orders_sn_specs.idorders ,orders_sn_specs.idrev, orders_sn_specs.idband, MIN(dpxlowstart) as v_unitdlstart , MAX(dpxlowstop) as v_unitdlstop , MIN(dpxhihgstart)as v_unitulstart , MAX(dpxhihgstop)as v_unitulstop  ,max(objectband.dlgain) as v_dlgain  ,max(objectband.ulgain) as v_ulgain , max(objectband.dlmaxpwr)as v_dlmaxpwr  , max(objectband.ulmaxpwr) as v_ulmaxpwr ,
							CASE  
									 when idband.description like '700%' then 0
									 when idband.description like '800%' then 1
									 when idband.description like 'VHF%' then 2
									 when idband.description like 'UHF%' then 3
									 else 99
								   end bandorder
						FROM orders_sn_specs
						inner join orders
						on orders.idorders  = orders_sn_specs.idorders and 
						orders.idrev  = orders_sn_specs.idrev
						 inner join idband
										on idband.idband = orders_sn_specs.idband
						inner join fnt_select_objectband_maxrev() as objectband
						on objectband.idproduct = orders.idproduct AND
						  objectband.idband = orders_sn_specs.idband 
	
						  inner join (
							select idproduct , idband, max(idrev)  as maxidrev
							from fnt_select_objectband_maxrev() as objectband where idproduct in (select idproduct from orders_sn where idorders = :idorders  )
							group by idproduct , idband
							) as losmax
							on losmax.idproduct = objectband.idproduct and
							losmax.idband = objectband.idband and
							losmax.maxidrev = objectband.idrev
	
							
						WHERE orders_sn_specs.idband NOT IN(8,1,6,7,15,16,17,18,19) and
						orders_sn_specs.idorders =:idorders AND typedata='DPX' AND idnroserie = 0 and orders_sn_specs.idrev = :idrev
						GROUP BY orders_sn_specs.idband,idband.description, orders_sn_specs.idorders ,orders_sn_specs.idrev
						union
							SELECT orders_sn_specs.idorders ,orders_sn_specs.idrev, 8, MIN(dpxlowstart), MAX(dpxlowstop), MIN(dpxhihgstart), MAX(dpxhihgstop) ,max(objectband.dlgain),max(objectband.ulgain), max(objectband.dlmaxpwr), max(objectband.ulmaxpwr),
							3 as  bandorder
						FROM orders_sn_specs
						inner join orders
						on orders.idorders  = orders_sn_specs.idorders and 
						orders.idrev  = orders_sn_specs.idrev
					
						inner join idband
						on idband.idband = orders_sn_specs.idband
						 inner join bandgroups
							  on bandgroups.idband = orders_sn_specs.idband  and                            
							  bandgroups.idbandgroup  IN(1,3)
						left join fnt_select_objectband_maxrev() as objectband
						on objectband.idproduct = orders.idproduct  
						  left join (
							select idproduct , idbandgroup, max(idrev)  as maxidrev
							from fnt_select_objectband_maxrev() as  objectband 
							  inner join bandgroups
							  on bandgroups.idband = objectband.idband and idbandgroup  IN(1,3)
							  where idproduct in (select idproduct from orders_sn where idorders = :idorders )
							group by idproduct , idbandgroup
							) as losmax
							on losmax.idproduct = objectband.idproduct and
							losmax.idbandgroup = bandgroups.idbandgroup and
							losmax.maxidrev = objectband.idrev
							
						WHERE orders_sn_specs.idband  IN(8,1,6,7)  and objectband.idband  IN(8,1,6,7) and
						orders_sn_specs.idorders =:idorders AND typedata='DPX' AND idnroserie = 0 and orders_sn_specs.idrev =0
							group by orders_sn_specs.idorders ,orders_sn_specs.idrev
	
	
							union
							SELECT orders_sn_specs.idorders ,orders_sn_specs.idrev ,orders_sn_specs.idband, MIN(dpxlowstart), MAX(dpxlowstop), MIN(dpxhihgstart), MAX(dpxhihgstop) ,max(objectband.dlgain),max(objectband.ulgain), max(objectband.dlmaxpwr), max(objectband.ulmaxpwr),
							4 as  bandorder
						FROM orders_sn_specs
						inner join orders
						on orders.idorders  = orders_sn_specs.idorders and 
						orders.idrev  = orders_sn_specs.idrev
					
						inner join idband
						on idband.idband = orders_sn_specs.idband
						 inner join bandgroups
							  on bandgroups.idband = orders_sn_specs.idband  and                            
							  bandgroups.idbandgroup  IN(25)
						left join fnt_select_objectband_maxrev() as objectband
						on objectband.idproduct = orders.idproduct  
						  left join (
							select idproduct , idbandgroup, max(idrev)  as maxidrev
							from fnt_select_objectband_maxrev() as  objectband 
							  inner join bandgroups
							  on bandgroups.idband = objectband.idband and idbandgroup  IN(25)
							  where idproduct in (select idproduct from orders_sn where idorders = :idorders )
							group by idproduct , idbandgroup
							) as losmax
							on losmax.idproduct = objectband.idproduct and
							losmax.idbandgroup = bandgroups.idbandgroup and
							losmax.maxidrev = objectband.idrev
							
						WHERE orders_sn_specs.idorders =:idorders AND typedata='DPX' AND idnroserie = 0 and orders_sn_specs.idrev =0
							group by orders_sn_specs.idorders ,orders_sn_specs.idrev,orders_sn_specs.idband
						
						) as tt1
							order by bandorder
						) as tt");
						$sentenciach->bindParam(':idorders', $vmaxid);								
						$sentenciach->bindParam(':idrev', $vconcero);
						$sentenciach->execute();
	
						
						$query_lista ="INSERT INTO orders_states(idorders, idstate, datestate)	VALUES (".$vmaxid.", 5, now());";
						$connect->query($query_lista);	
						
						$query_lista ="	update orders_sn_specs set idband =  idband.idband 
from  idband
where idband.fstartdl   = orders_sn_specs.unitdlstart and 
	idband.fstopdl   = orders_sn_specs.unitdlstop and 
	idband.fstartul    = orders_sn_specs.unitulstart and 
	idband.fstopul    = orders_sn_specs.unitulstop
and  orders_sn_specs.idband is null ";
	$connect->query($query_lista);
$query_lista ="update orders_sn_specs set idband =  idband.idband 
from  idband
where idband.fstartdl   = orders_sn_specs.dpxlowstart  and 
	idband.fstopdl   = orders_sn_specs.dpxlowstop  and 
	idband.fstartul    = orders_sn_specs.dpxhihgstart and 
	idband.fstopul    = orders_sn_specs.dpxhihgstop
and  orders_sn_specs.idband is null ";


						$connect->query($query_lista);

						////// QUERY UPDATE GAIN Y MAXPWR  desde Obj band
						$query_lista_objband="update orders_sn_specs
						set ulgain = maxrevidband.ulgain , 
							dlgain = maxrevidband.dlgain , 
							ulmaxpwr = maxrevidband.ulmaxpwr, 
							dlmaxpwr = maxrevidband.dlmaxpwr
						from orders_sn_specs as osp
						inner join orders_sn
						on orders_sn.idorders = osp.idorders and 
						orders_sn.idrev = osp.idrev and
						orders_sn.idnroserie = osp.idnroserie
						inner join fnt_select_objectband_maxrev() as maxrevidband
						on maxrevidband.idband = osp.idband and
						   maxrevidband.idproduct  = orders_sn.idproduct
						where  orders_sn_specs.idorders IN(".$vmaxid.") AND
						orders_sn_specs.idorders = osp.idorders and 
						orders_sn_specs.idrev = osp.idrev and
						orders_sn_specs.idnroserie = osp.idnroserie and
						orders_sn_specs.typedata = 'UNIT'  
						 ";
						$connect->query($query_lista_objband);
						
					$IndSN=1;

					$sqlmaxrev = $connect->prepare(" select orders.idorders 
					from orders
					inner join orders_sn 
					on orders_sn.idorders = orders.idorders
					inner join fnt_select_allproducts_maxrev() as products 
					on products.idproduct = orders_sn.idproduct
					where  iduniquebranchsonprod like '00010091%' and orders.idorders = :v_idorders ");
					$sqlmaxrev->bindParam(":v_idorders", $vmaxid);		
					$sqlmaxrev->execute();
					$result = $sqlmaxrev->fetchAll();				
					 $v_ciuislegacy="N";
						foreach ($result as $row) 
						{
							$v_ciuislegacy="Y";
						}
					
						if ($v_ciuislegacy=="Y")
						{

							$query_lista ="INSERT INTO orders_states(idorders, idstate, datestate)	VALUES (".$vmaxid.", 7, (now() + interval '2 minute') );";
							$connect->query($query_lista);	

							$query_lista =" update orders set typeregister = 'SO' where idorders = ".$vmaxid." and typeregister = 'PO' ;";
							$connect->query($query_lista);	

						}	


						/// INSERT para SERVIDOR DE peticions :: petitions_server
					
						$iduuff = 	$_SESSION["a"];
						$iduu = 22; /// usuario del servidor
						$v_id_station = 13; // station del servidor;

					 $parajson= '{"idorders":'.$vmaxid.'}';
						$sqlpetiti ="INSERT INTO public.fas_petitions_server(
idpetition, petitiontype, iduserfrom, iduserto, idstationto, instance, date, status, exitstatus, parameters1, parameters2, parameters3, idexterna)
VALUES ((select COALESCE(max(idpetition),0) + 1 from fas_petitions_server), 2, ".$iduuff.", ".$iduu.", ".$v_id_station.",'04F', now(), 0, null, '".$parajson."', null, null, null);";


						$connect->query($sqlpetiti);

					/// fin petitions_server
					
					///// PASAMOS LOS VALORES 9999 a NA. porque no tiene datos el productos.
					$sqlquery9999 = "update orders_sn_specs set dlmaxpwr = null where dlmaxpwr = 9999 and idorders = ".$vmaxid;
 					$connect->query($sqlquery9999);
					 $sqlquery9999 = "update orders_sn_specs set ulmaxpwr = null where ulmaxpwr = 9999 and idorders = ".$vmaxid;
 					$connect->query($sqlquery9999);
					 $sqlquery9999 = "update orders_sn_specs set ulgain = null where ulgain = 9999 and idorders = ".$vmaxid;
 					$connect->query($sqlquery9999);
					 $sqlquery9999 = "update orders_sn_specs set dlgain = null where dlgain = 9999 and idorders = ".$vmaxid;
 					$connect->query($sqlquery9999);
					
					///// PARA BTTY TODO LOPASAMOS A DISPONIBLE PARA STOCK
					 $sql2fix = $connect->prepare("	update orders_sn set availablesn = true      where idorders = :vvidlog   and  typeregister= 'WO'  and availablesn is  null 
					 and idproduct in ( 
						 			select distinct products.idproduct from fnt_select_allproducts_maxrev() as products  where   iduniquebranchsonprod like '%000100370041%' 
									 )   ");
					 $sql2fix->bindParam(':vvidlog', $vmaxid);
					  $sql2fix->execute();

				
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
							  title: 'WO Saved!',
							  text: "Add a new WO ?",
							  icon: 'success',
							  showCancelButton: true,
							  confirmButtonColor: '#3085d6',
							  cancelButtonColor: '#d33',
							  confirmButtonText: 'Yes',
							  cancelButtonText: 'No', 
							}).then((result) => {
							  if (result.value) 
							  {
								window.location="generawororder.php"; 
							  }
							  else
							  {
								 window.location="listwordorder.php";
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
            <h1>Create Work Orders</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Create Work Order </li>
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
			<a href="listwordorder.php" style="color:#0053a1;"><i class='fas fa-search' style='font-size:24px;color:#0053a1;'></i>  &nbsp;List Work Orders</a> &nbsp;&nbsp;
			<hr>
			</p>

				  
			<!-- aca form -->
			
			      <form action="changeuserfasdata.php" method="post" class="form-horizontal" name="frmpass" id="frmpass">
	
	
			
				  
      </form>
		
	 
							 <form  action="generawororder.php" method="post" class="form-horizontal" id="myform" name="myform">
							 <input type="hidden" class="form-control" id="txtponumber" name="txtponumber"  value="WO">
							 <input type="hidden"  id="txtlistcustomers" name="txtlistcustomers" value="2">
				
						<div class="progress progress-xxs">
							 <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
							 </div>
						</div>
						<br>
					<!-- NUEVO RENGLON FORM  -->
					<div class="form-group row" >
						<label for="inputPassword" class="col-sm-1 col-form-label">Nro WO:</label>
						<div class="col-sm-4">
						<input type="text" class="form-control col-4" id="txtnrowoingreso" name="txtnrowoingreso"    placeholder="________WO" value="">	
						<span id="lblerrorwo" name="lblerrorwo" class="text-danger">  </span>
						</div>
					</div>
					<div class="form-group row" >
					<label for="inputPassword" class="col-sm-1 col-form-label">Ciu Model:</label>
					<div class="col-sm-8	">
					
						<select class="js-example-basic-single col-sm-8"    id="txtlistcius" name="txtlistcius">
						</select>
					
					
					
						</div>
					<label for="inputPassword" class="col-sm-1 col-form-label">Quantity:</label>
					<div class="col-sm-2">
					<input type="number" class="form-control col-3" id="txtcant" name="txtcant" data-smk-type="number" min="1" max="99"   placeholder="quantity" value="1"  onKeyUp="if(this.value>99){this.value='99';}else if(this.value<0){this.value='0';}">	

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
					<label for="inputPassword" class="col-sm-2 col-form-label">Notes :</label>
					<div class="col-sm-4">
						  <textarea class="form-control"  id="txtnotepo" name="txtnotepo"  data-validate="false" rows="4"></textarea>
					</div>
				  </div>
				 
					<!-- NUEVO RENGLON FORM  -->
					<!-- NUEVO RENGLON FORM  -->
					<div class="form-group row">
					<label for="inputPassword" class="col-sm-2 col-form-label">POWER SUPPLY TYPE:</label>
					<div class="col-sm-2">
								<select  id="txtpwrsupply" name="txtpwrsupply"  class="custom-select my-1 mr-sm-2 form-control"  >
								<option value="">-select-</option>
								<option value="AC">AC</option>
								<option value="DC">DC</option>
								<option value="AC/DC">AC/DC</option>
						
								</select>
					</div>
					<label for="inputPassword" class="col-sm-1 col-form-label">RC-G for BWA:</label>
					<div class="col-sm-1">
						
						<input type="checkbox"  data-toggle="toggle"  data-off="NO" data-on="YES" id="txtrcgbwa" name="txtrcgbwa" >
					</div>
					<label for="inputPassword" class="col-sm-1 col-form-label">Modem for Digital:</label>
					<div class="col-sm-1">
						<input type="checkbox"  data-toggle="toggle" data-on="YES" data-off="NO" id="txtmoden" name="txtmoden" >
						

					</div>
				  </div>
					<!-- NUEVO RENGLON FORM  -->
					
					  <!-- NUEVO RENGLON FORM  -->
					<div class="form-group row d-none">
					<label for="inputPassword" class="col-sm-2 col-form-label">DL gain (dB)</label>
					<div class="col-sm-4	">
					  <input type="number" class="form-control" id="txtdlgain" name="txtdlgain" min="1"  placeholder="DL GAIN (dB)"  >
					</div>
					<label for="inputPassword" class="col-sm-2 col-form-label">UL gain (dB)</label>
					<div class="col-sm-4">
					  <input type="number" class="form-control" id="txtulgain" name="txtulgain" min="1"  placeholder="UL GAIN (dB)"  >
					</div>
				  </div>
				  
					<!-- NUEVO RENGLON FORM  -->
					  <!-- NUEVO RENGLON FORM  -->
					<div class="form-group row d-none">
					<label for="inputPassword" class="col-sm-2 col-form-label">DL Max Pwr Out (dBm)</label>
					<div class="col-sm-4	">
					  <input type="number" class="form-control" id="txtdlmaxpwr" name="txtdlmaxpwr" min="1"  placeholder="DL Max Pwr Out (dBm)"  >
					
					</div>
					<label for="inputPassword" class="col-sm-2 col-form-label">UL Max Pwr Out (dBm)</label>
					<div class="col-sm-4">
					  <input type="text" class="form-control" id="txtulmaxpwr" name="txtulmaxpwr"    placeholder="UL Max Pwr Out (dBm)"  >
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
							<td><label  class=" col-form-label">Unit DL (MHz): Start: </label>	<input type="number" class="form-control col-sm-4" id="txtchudstart" min="1" data-validate="false" name="txtchudstart" placeholder="000.000"></td>
							<td><label  class=" col-form-label">  &nbsp; Stop: </label>  <input type="number" class="form-control  col-sm-4" id="txtchudstop" data-validate="false" name="txtchudstop" placeholder="000.000"> </td>
						</tr>
						<tr>
							<td><label  class=" col-form-label">Unit UL (MHz):	   Start: </label> <input type="number" class="form-control  col-sm-4" id="txtchulstart" min="1" data-validate="false" name="txtchulstart" placeholder="000.000"> </td>
							<td><label  class=" col-form-label">  &nbsp; Stop: </label>  <input type="number" class="form-control  col-sm-4" id="txtchulstop" data-validate="false" name="txtchulstop" placeholder="000.000">  </td>
						</tr>
						<tr>
							<td> &nbsp; </td>
							<td>
							 <button name="btnlist_gain" id="btnlist_gain" type="button" class="btn btn-smk btn-outline-primary btn-flat" onclick="add_list_gain()">Add to List</button>
						<input type="hidden" class="form-control" id="templistagainuldl" name="templistagainuldl">
							</td>
						</tr>			
					</table>		
							
						
					
					</div>
					
					<div class="col-sm-6">
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
				  
							<!-- NUEVO RENGLON FORM  -->
					<div class="form-group row">
				  
					<div class="col-sm-6">
					 <table class="table " >
						
						<tr>
							<td><label  class=" col-form-label">DPX low pass start (MHz): </label>	<input type="number" class="form-control col-sm-4" min="1" id="txtdpxlowstart"  name="txtdpxlowstart" placeholder="000.000"></td>
							<td><label  class=" col-form-label">  &nbsp; Stop (MHz): </label>  <input type="number" class="form-control  col-sm-4" min="1" id="txtdpxlowstop" data-validate="false" name="txtdpxlowstop" placeholder="000.000"> </td>
						</tr>
						<tr>
							<td><label  class=" col-form-label">DPX high pass start (MHz): </label> <input type="number" class="form-control  col-sm-4" min="1" id="txtdpxhighstart"  name="txtdpxhighstart" placeholder="000.000"> </td>
							<td><label  class=" col-form-label">  &nbsp; Stop (MHz): </label>  <input type="number" class="form-control  col-sm-4" min="1" id="txtdpxhighstop" data-validate="false" name="txtdpxhighstop" placeholder="000.000">  </td>
						</tr>
						<tr>
							<td> &nbsp; </td>
							<td>
							 <button name="btnlist_dpx" id="btnlist_dpx" type="button" class="btn btn-smk btn-outline-primary btn-flat" onclick="add_list_dpx()">Add to DPX List</button>
						<input type="hidden" class="form-control" id="templistadpx" name="templistadpx">
							</td>
						</tr>			
					</table>		
							
						
					
					</div>
					
					<div class="col-sm-6">
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
						<button type="button" class="btn btn-primary btn-block" id="btnchangep" name="btnchangep">Create New WO</button>
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
	return (key >= 48 && key <= 57)
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
		   
		   
			
				$("#txtnrowoingreso").blur(function(){
					if ($("#txtnrowoingreso").val().length ==10)
					{
						if ($("#txtnrowoingreso").val().indexOf("WO")==8)
						{
							/// Validar si no esta en USO....
							$.ajax
							({ 
								url: 'checknrowousado.php',
								data: "wo="+ $("#txtnrowoingreso").val(),	
								type: 'post',				
								datatype:'JSON',                
								success: function(data)
								{
									
									if (data.result =="used")
									{
										console.log(data.result);
										$("#lblerrorwo").text('Error: WO already used');
										alert('WO already used ');
										//toastr["error"]("Error, WO already used ...", "");	
										$("#txtnrowoingreso").val('');
										$("#lblerrorwo").text('');
									}
									
								}
							});
							
							$("#lblerrorwo").text('');
						}
						else
						{
							$("#txtnrowoingreso").focus();
							$("#lblerrorwo").text('Format error. Must contain 8 digits + WO');
						}
					
					}
					else
					{
						$("#txtnrowoingreso").focus();
					$("#lblerrorwo").text('Format error. Must contain 8 digits + WO');
					}
					
				});
	
		
			$("#txtlistcius").change(function(){
				var tabla_info_show_po = "";	

//Limpiamos Array de CH UNI DPX	

console.log(tabla_channel_quantity.length);
   tabla_channel_quantity.length=0;
 tabla_gain_dlul.length=0;
 tabla_dpx.length=0;	
					
				 $.ajax
				({ 
					url: 'checksousadowoonlywo.php',
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
						}	

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
							   $("#txtdlgain").val(data.dlgain);
							   $("#txtdlmaxpwr").val(data.dlmaxpwr);
							   $("#txtulgain").val(data.ulgain);
							   $("#txtulmaxpwr").val(data.ulmaxpwr);
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
											
											tabla_gain_dlul.push({	
												Band:itempsunit.nomband,
												gainudstart: parseFloat(itempsunit.fstartdl),
												gainudstop: parseFloat(itempsunit.fstopdl),
												gainulstart: parseFloat(itempsunit.fstartul),
												gainulstop: parseFloat(itempsunit.fstopul)
												
												
												
									   });
									   
									   tabla_dpx.push({	
												Band:itempsunit.nomband,												
												dpxlowstart: parseFloat(itempsunit.fstartdl),
												dpxlowstop:  parseFloat(itempsunit.fstopdl),
												dpxhighstart: parseFloat(itempsunit.fstartul),
												dpxhighstop: parseFloat(itempsunit.fstopul)
												 });
									   
									});
									
						   
								tabla_gain_udul2dagen();
								 list_tabla_dpx_udul2dagen();
							 
								  
								
							 // $('#generalinfopo').html(tabla_info_show_po); 
									
						
						
						
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
        page: params.page,
        from: 'WO'		//
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
		
			$("#frmwo").addClass('d-none');	
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
		//		  html += '<th>Action</th>';
				 html += '</tr>';
				 for( var i = 0; i < tabla_dpx.length; i++) {
				  html += '<tr>';
				  
				  if (v_temp_dpx != '')
				  {
					v_temp_dpx = v_temp_dpx + "#";  
				  }
				  
				  for( var j in tabla_dpx[i] ) {
					 
					if (j =='Band')
						{
							html += '<td>' + tabla_dpx[i][j]  +' </td>';	  
						}
						else
						{
							html += '<td>' + tabla_dpx[i][j]  +' MHz</td>';	    
						}
						v_temp_dpx = v_temp_dpx  + tabla_dpx[i][j] + "|"
					
					
				  }
			//	  html += '<td>  <a href="#" onclick="borrar_array_dpx('+i+')"> <i class="fas fa-trash-alt"></i> Del</a> </td>';	  
				  html += '</tr>';
				 }
				 html += '</table>';
				 v_temp_dpx = v_temp_dpx + "#";  
				 console.log(v_temp_dpx);
				 	$('#listadpx').html(html);
					$('#templistadpx').val(v_temp_dpx);
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
					 
					if (j =='Band')
						{
							html += '<td>' + tabla_dpx[i][j]  +' </td>';	  
						}
						else
						{
							html += '<td>' + tabla_dpx[i][j]  +' MHz</td>';	    
						}

				
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
					 console.log('abc:' +j);
				
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
				
		
	}
	
	function tabla_gain_udul2dagen()
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
				//  html += '<th>Action</th>';
				 html += '</tr>';
				 for( var i = 0; i < tabla_gain_dlul.length; i++) {
				  html += '<tr>';
				  
				  if (v_templistchannel != '')
				  {
					v_templistchannel = v_templistchannel + "#";  
				  }
				  
				  for( var j in tabla_gain_dlul[i] ) {
				///	console.log('ab2c:' +j);
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
				//  html += '<td>  <a href="#" onclick="borrar_array_uldl('+i+')"> <i class="fas fa-trash-alt"></i> Del</a> </td>';	  
				  html += '</tr>';
				 }
				 html += '</table>';
				 v_templistchannel = v_templistchannel + "#";  
				 console.log(v_templistchannel);
				 	$('#listagainuldl').html(html);
					$('#templistagainuldl').val(v_templistchannel);
				
		
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
									Band: 'Add',					
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
			 console.log('a ver listo para el submit');
			//if (tabla_channel_quantity.length >= 1 )
		//	{
				if (tabla_gain_dlul.length >= 1  )	
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
		else
		{
			if ($("#txtlistcius").val() !='' && $("#txtcant").val() >0  )	
			{
				if (tabla_gain_dlul.length >= 1  )	
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
			}
			else
			{
				alert( "CIU / Quantity is required. ");	
			}
			
		}
	 }
	 else
	 {
		//	alert('mam');
									
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

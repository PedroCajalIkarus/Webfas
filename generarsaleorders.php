<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
//error_reporting(0);
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
	
			$sql = $connect->prepare("SELECT idband, description, fstartul, fstopul, fstartdl, fstopdl , issubband, issubbandof 	FROM idband ");
					$sql->execute();
					$resultado = $sql->fetchAll();
					 foreach ($resultado as $row2) {
						
						 $arr_idband[] = array("idband" => $row2['idband'],
													"fstartul" => $row2['fstartul'],
													"fstopul" => $row2['fstopul'],
													"fstartdl" => $row2['fstartdl'],
													"fstopdl" => $row2['fstopdl'],
													"issubband" => $row2['issubband'],
													"issubbandof" => $row2['issubbandof'],
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
	///	header("Location: http://".$ipservidorapache."/".$folderservidor."/usertnotstation.php?b=".$_SESSION["b"]."&c=".array_pop(explode('/', $_SERVER['PHP_SELF'])));
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
		$txtsonumberlu = trim($_REQUEST['txtsonumberlu']); //
		$v4 = $_REQUEST['txtpwrsupply']; //
		$vsaleordentmp = $_REQUEST['txtsonumber']; // txtsonumber		
		$v5 = $_REQUEST['txtrcgbwa']; ///$vidcustomer

		$txthavemodulerabbit = $_REQUEST['txthavemodulerabbit'];
		
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
		
		
		$esdiego = $_REQUEST['esdiego']; //
		
			$esDH7Signalbuster_pasadirectoalfasclient= 'N';
				$sql = $connect->prepare("select distinct products.idproduct
				from products 
				inner join objectband
				on objectband.idproduct = products.idproduct
				where products.idproduct = ".$v1." and typeproduct in( 'SIGNAL BOOSTER','PSC MASTER') and idrevproduct in (select max(idrevproduct) from products where idproduct = ".$v1." )
				");
				$sql->execute();
				$resultado = $sql->fetchAll();
				 foreach ($resultado as $row) {
					$esDH7Signalbuster_pasadirectoalfasclient= 'Y';
					
				 }
				 ////]PASA SIEMPRE DIRECTO;.,
				 $esDH7Signalbuster_pasadirectoalfasclient= 'Y';
		
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

		//	echo "aca 1";
		 


		$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->beginTransaction();
			 try {
					//$connect->query($sql);

					if ($esdiego >0)					
					{
					//	echo "Borramos".$esdiego;
						/// Borramos y volvemos a insertarrr
						$sentencia = $connect->prepare("delete from orders where idorders = :bidorders ");															
						$sentencia->bindParam(':bidorders', $esdiego);
						$sentencia->execute();
						$sentencia = $connect->prepare("delete from orders_sn where idorders = :bidorders ");															
						$sentencia->bindParam(':bidorders', $esdiego);
						$sentencia->execute();
						$sentencia = $connect->prepare("delete from orders_sn_specs where idorders = :bidorders ");															
						$sentencia->bindParam(':bidorders', $esdiego);
						$sentencia->execute();

						$activereg = "Y";
						$vmaxid =$esdiego;
					}	
					else
					{
						// Lo dejamos en Borrador
						if ($esDH7Signalbuster_pasadirectoalfasclient== 'Y')
						{
							$activereg = "Y";
						}
						else
						{
							$activereg = "Y";
						}


						$activereg = "Y";

						
						
					}
						$typeregister="SO";
						$nrowoautogenrado = "000000000".$vmaxid."PO";
						$nrowoautogenrado =   substr($nrowoautogenrado, -10); 
						
						///****** inserto orders de WO-----
						$sentencia = $connect->prepare("INSERT INTO orders(idorders, idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, idrev, idruninfo, date_approved, quantity, typeregister, processday, processfasserver, nameapproved ,active, fassrverror) VALUES (:idorders, :idcustomers, :idfamilyprod, :idtypeband, :idtypeproduct, :idproduct, :idconfiguration, :idrev, :idruninfo, now(), :quantity, :typeregister, :processday, :processfasserver, :nameapproved,'Y', :fassrverror);");
															
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
					
				//		$sentencia->bindParam(':active', $activereg);					
						$sentencia->bindParam(':fassrverror', $vvacio);							
								
						$sentencia->execute();
				//		echo "aca 2";

						//// tkkeymarco1
						////aca vamos a copiar los attach y los asociamos..
						$v_tkkeymarco1 = $_REQUEST['tkkeymarco1']; //
						$sentenciaatt = $connect->prepare("insert into orders_fileattach SELECT idordersfileat,:idorders, namefileattach, seedtemp FROM public.orders_fileattach_draft where active = 'draft' and seedtemp = :seedtemp");
						$sentenciaatt->bindParam(':idorders', $vmaxid);
						$sentenciaatt->bindParam(':seedtemp', $v_tkkeymarco1);
						$sentenciaatt->execute();
					//	echo "insert into orders_fileattach SELECT idordersfileat,".$vmaxid.", namefileattach, seedtemp FROM public.orders_fileattach_draft where active = 'draft' and seedtemp =".$v_tkkeymarco1;

					 
						
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
								
								$sentenciach = $connect->prepare("INSERT INTO public.orders_sn_specs(idorders, idrev, idch, idnroserie, typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, notes, idband)	VALUES (:idorders, :idrev, :idch, :idnroserie, :typedata, :ul_ch_fr, :dl_ch_fr, :dpxlowstart, :dpxlowstop, :dpxhihgstart, :dpxhihgstop, :unitdlstart, :unitdlstop, :unitulstart, :unitulstop, :notes, :idband);");
								
								$sentenciach->bindParam(':idorders', $vmaxid);								
								$sentenciach->bindParam(':idrev', $vconcero);
								$sentenciach->bindParam(':idch', $vidch);
								$sentenciach->bindParam(':idnroserie', $vconcero);
								$sentenciach->bindParam(':typedata', $vtypedata);
								$sentenciach->bindParam(':ul_ch_fr', str_replace(",",".",$separa_ULDL[1]));
								$sentenciach->bindParam(':dl_ch_fr', str_replace(",",".",$separa_ULDL[0]));
								$sentenciach->bindParam(':dpxlowstart', $vconcero);
								$sentenciach->bindParam(':dpxlowstop', $vconcero);
								$sentenciach->bindParam(':dpxhihgstart', $vconcero);
								$sentenciach->bindParam(':dpxhihgstop', $vconcero);
								$sentenciach->bindParam(':unitdlstart', $vconcero);
								$sentenciach->bindParam(':unitdlstop', $vconcero);
								$sentenciach->bindParam(':unitulstart', $vconcero);
								$sentenciach->bindParam(':unitulstop', $vconcero);							
								$sentenciach->bindParam(':notes', $vnotech);
								$sentenciach->bindParam(':idband', str_replace(",",".",$separa_ULDL[2]));
								
								$sentenciach->execute();
								
								/////////////////////////////////////////////////////////////////////////////////////
								/////////////////////////////////////////////////////////////////////////////////////								
								$vdescripaudit="NEW REG presales_specs".$vuserfas;		
								$vtextaudit="INSERT INTO public.orders_sn_specs(idorders, idrev, idch, idnroserie, typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, notes)	VALUES (:idorders, :idrev, :idch, :idnroserie, :typedata, :ul_ch_fr, :dl_ch_fr, :dpxlowstart, :dpxlowstop, :dpxhihgstart, :dpxhihgstop, :unitdlstart, :unitdlstop, :unitulstart, :unitulstop, :notes);";
								$vtextaudit=$vtextaudit."!!idorders:".$vmaxid;
								$vtextaudit=$vtextaudit."!!idrev:".$vconcero;
								$vtextaudit=$vtextaudit."!!idch:".$vidch;
								$vtextaudit=$vtextaudit."!!typedata:".$vtypedata;
								$vtextaudit=$vtextaudit."!!ul_ch_fr:".str_replace(",",".",$separa_ULDL[1]);
								$vtextaudit=$vtextaudit."!!dl_ch_fr:".str_replace(",",".",$separa_ULDL[0])."".$separa_ULDL[2];
							
								
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();								
								
								/////////////////////////////////////////////////////////////////////////////////////
								/////////////////////////////////////////////////////////////////////////////////////	
									
								$vidch = $vidch + 1 ;	
							}
							
						}
					 //$varray_LISTDPX
				//	 echo "aca 3";
					 
						$vvidband =5;  //UNKNOW
					 $porciones = explode("#", $varray_LISTDPX);
					 $vidchdpx=1;
					 $vtypedata="DPX";
					   foreach($porciones as $elcanaluldl) {
							//echo "el canal:".$elcanaluldl;
							$separa_DPX  = explode("|", $elcanaluldl);
						///	echo "low".$separa_DPX[0]."--".$separa_DPX[1]."<br>";
							if ($elcanaluldl <> "")
							{
								// insetamos channel detalle PO
								 
									$vnotech  = $_REQUEST['txtnotedpc']; //
									 //UNKNOW
									$vvidband =5;  //UNKNOW
							 
										foreach ($arr_idband as $key => $value) {
											//	echo $key . ":  " . $value['idband'] . "-" . $value['fstartul']. "-" . $value['fstopul']. "-" . $value['fstartdl']. "-" . $value['fstopdl'] . "<br>";
												if ( $value['nombreband'] == $separa_DPX[0]  )
												{
													$vvidband = $value['idband'];
												//	echo "<br>issubband:".$value['issubband'];
													if ($value['issubband']=="true")
													{
														$vvidband = $value['issubbandof'];
													}

												}
										}
								 

								if ( $separa_DPX[5] <>"0")	
								{
							$sentenciach = $connect->prepare("INSERT INTO public.orders_sn_specs(idorders, idrev, idch, idnroserie, typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, notes, idband)	VALUES (:idorders, :idrev, :idch, :idnroserie, :typedata, :ul_ch_fr, :dl_ch_fr, :dpxlowstart, :dpxlowstop, :dpxhihgstart, :dpxhihgstop, :unitdlstart, :unitdlstop, :unitulstart, :unitulstop, :notes, :idband);");
								$sentenciach->bindParam(':idorders', $vmaxid);								
								$sentenciach->bindParam(':idrev', $vconcero);
								$sentenciach->bindParam(':idch', $vidchdpx);
								$sentenciach->bindParam(':idnroserie', $vconcero);
								$sentenciach->bindParam(':typedata', $vtypedata);
								$sentenciach->bindParam(':ul_ch_fr', $vconcero);
								$sentenciach->bindParam(':dl_ch_fr', $vconcero);
								$sentenciach->bindParam(':dpxlowstart', str_replace(",",".",$separa_DPX[5])); //1
								$sentenciach->bindParam(':dpxlowstop', str_replace(",",".",$separa_DPX[6])); //2
								$sentenciach->bindParam(':dpxhihgstart', str_replace(",",".",$separa_DPX[7])); //3
								$sentenciach->bindParam(':dpxhihgstop', str_replace(",",".",$separa_DPX[8])); //4
								$sentenciach->bindParam(':unitdlstart', $vconcero);
								$sentenciach->bindParam(':unitdlstop', $vconcero);
								$sentenciach->bindParam(':unitulstart', $vconcero);
								$sentenciach->bindParam(':unitulstop', $vconcero);
								$sentenciach->bindParam(':notes', $vnotech);
								$sentenciach->bindParam(':idband', $vvidband);
									
								$sentenciach->execute();
						//		echo "<br>INSERT";
								/////////////////////////////////////////////////////////////////////////////////////
								/////////////////////////////////////////////////////////////////////////////////////								
								$vdescripaudit="NEW REG presales_specs".$vuserfas;		
								$vtextaudit="INSERT INTO public.orders_sn_specs(idorders, idrev, idch, idnroserie, typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, notes,idband)	VALUES (:idorders, :idrev, :idch, :idnroserie, :typedata, :ul_ch_fr, :dl_ch_fr, :dpxlowstart, :dpxlowstop, :dpxhihgstart, :dpxhihgstop, :unitdlstart, :unitdlstop, :unitulstart, :unitulstop, :notes,:idband);";
								$vtextaudit=$vtextaudit."!!idorders:".$vmaxid;
								$vtextaudit=$vtextaudit."!!idrev:".$vconcero;
								$vtextaudit=$vtextaudit."!!idch:".$vidch;
								$vtextaudit=$vtextaudit."!!typedata:".$vtypedata;
								$vtextaudit=$vtextaudit."!!dpxlowstart:".str_replace(",",".",$separa_DPX[5]); //1
								$vtextaudit=$vtextaudit."!!dpxlowstop:".str_replace(",",".",$separa_DPX[6]); //2
								$vtextaudit=$vtextaudit."!!dpxhihgstart:".str_replace(",",".",$separa_DPX[7]); //3
								$vtextaudit=$vtextaudit."!!dpxhihgstop:".str_replace(",",".",$separa_DPX[8]); //4
								$vtextaudit=$vtextaudit."!!idband:".$vvidband;
							
								
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();								
								
								/////////////////////////////////////////////////////////////////////////////////////
								/////////////////////////////////////////////////////////////////////////////////////	
									
								$vidchdpx = $vidchdpx + 1 ;	
								}
							}
							
						}
						
						
					//$varray_LISTUNIT
					/*
					/// Duplicamos los DPX en UNIT

			*/
 

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
						SELECT orders_sn_specs.idorders ,orders_sn_specs.idrev, orders_sn_specs.idband, MIN(dpxlowstart), MAX(dpxlowstop), MIN(dpxhihgstart), MAX(dpxhihgstop) ,max(objectband.dlgain),max(objectband.ulgain), max(objectband.dlmaxpwr), max(objectband.ulmaxpwr),
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


				  //// add here hace module rabbit
				////	  $txthavemodulerabbit

					  $query_lista ="INSERT INTO public.orders_attributes(idorders, idattribute_orders, datemodif, v_boolean, v_integer, v_double, v_string, v_date) VALUES (".$vmaxid.", 1,now(),".$txthavemodulerabbit.", NULL, NULL, NULL, NULL);";
						$connect->query($query_lista);
						
						$query_lista ="INSERT INTO orders_states(idorders, idstate, datestate)	VALUES (".$vmaxid.", 1,   (now() - interval '2 minute') );";
						$connect->query($query_lista);

					 
							$query_lista ="INSERT INTO orders_states(idorders, idstate, datestate)	VALUES (".$vmaxid.", 2, (now() - interval '1 minute') );";
							$connect->query($query_lista);		
				 
						 
						
						if ( $txtsonumberlu <> "")
						{
							$query_lista ="INSERT INTO orders_states(idorders, idstate, datestate)	VALUES (".$vmaxid.", 3, now());";
							$connect->query($query_lista);		

						}
						
						$msjalertglobo="New PO: ".$v3." to process";
						$msjlink="listpresales.php";
					/*	$query_lista2 ="INSERT INTO notices_users select ( select count(idnotice)+1 from notices_users),1 ,".$_SESSION["i"].", now(), null, '$msjalertglobo', '$msjlink'";						
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
						$connect->query($query_lista2);*/
						
						$vdescripaudit="NEW REG presales_states  -  notices_users";		
								$vtextaudit="INSERT INTO presales_states(idpresales, idstate, datestate)	VALUES (".$vmaxid.", 1, now()); // users in(1,2,17,16,11,20,)";
						
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();	

								
					
					$return_result_insert="ok";

					///// PASAMOS LOS VALORES 9999 a NA. porque no tiene datos el productos.
					$sqlquery9999 = "update orders_sn_specs set dlmaxpwr = null where dlmaxpwr = 9999 and idorders = ".$vmaxid;
 					$connect->query($sqlquery9999);
					 $sqlquery9999 = "update orders_sn_specs set ulmaxpwr = null where ulmaxpwr = 9999 and idorders = ".$vmaxid;
 					$connect->query($sqlquery9999);
					 $sqlquery9999 = "update orders_sn_specs set ulgain = null where ulgain = 9999 and idorders = ".$vmaxid;
 					$connect->query($sqlquery9999);
					 $sqlquery9999 = "update orders_sn_specs set dlgain = null where dlgain = 9999 and idorders = ".$vmaxid;
 					$connect->query($sqlquery9999);



				//	echo "amarco";
				 
				//	echo "famarco";
					////// Insetmoas
					/// inicio petitions_server
						
								/// INSERT para SERVIDOR DE peticions :: petitions_server
								$v_id_station = 	$_SESSION["k"]  	 ; //id station for user business
								$iduuff = 	$_SESSION["a"];
								$iduu = 22; /// usuario del servidor
								$v_id_station = 13; // station del servidor;

								$v_esciu = 	$_REQUEST["esciu"];
								$v_temocus = 	$_REQUEST["esnamecus"];

							
							/*
							*idpetition codigo interno de tabla para identificar la peticion
							*petitiontypoe es el tipo de peticion soportada 
							*instancia define el iduniquebranch del fas_tree
							*date es la fecha en la que se ingreso la peticion
							*status 0=En espera, 1= Procesando, 2= Procesamiento completado exitosamente, 3= Procesado con error.
							*statussalida. Cadena de descripción del error, si ESTADO=3. En ciertas peticiones, si está antecedido de la palabra WARNING: se indica que la petición se llevó a cabo pero hubieron problemas
							*/
							

								
						 $parajson= '{"so":"'.$txtsonumberlu.'","customer":"'.$v_temocus.'","ciu":"'.$v_esciu.'"}';
					///	 echo "<br>".$parajson;
						 $sqlpetiti ="INSERT INTO public.fas_petitions_server(
 idpetition, petitiontype, iduserfrom, iduserto, idstationto, instance, date, status, exitstatus, parameters1, parameters2, parameters3, idexterna)
 VALUES ((select COALESCE(max(idpetition),0) + 1 from fas_petitions_server), 2, ".$iduuff.", ".$iduu.", ".$v_id_station.",'04D068', now(), 0, null, '".$parajson."', null, null, null);";
 
 
						 $connect->query($sqlpetiti);
				 
						 	 	/////////////////////////////////////////////////////////////////////////////////////
							//////AUDITAMOS///////////////////////////////////////////////////////////////////////////////
							$vuserfas = $_SESSION["b"];
							$typeregister="PO";
							$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
							$vaccionweb="MarcoControlpetiti";
							$vdescripaudit="MarcoControlpetiti".$parajson;
							$vtextaudit=$slqband."***".	$sqlpetiti;
						
					
									$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
									$sentenciaudit->bindParam(':userfas', $vuserfas);								
									$sentenciaudit->bindParam(':menuweb', $vmenufas);
									$sentenciaudit->bindParam(':actionweb', $vaccionweb);
									$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
									$sentenciaudit->bindParam(':textaudit', $vtextaudit);
									$sentenciaudit->execute();
									
					/////////////////////////////////////////////////////////////////////////////////////
					$connect->query($sqlpetiti);
			
						/// inicio petitions_server para solicitar la generacion de SN

						$sqlmaxrev = $connect->prepare(" select orders.idorders 
						from orders
						inner join orders_sn 
						on orders_sn.idorders = orders.idorders
						inner join fnt_select_allproducts_maxrev() as products 
						on products.idproduct = orders_sn.idproduct
						where (iduniquebranchsonprod like '000100010038%' or iduniquebranchsonprod like '000100010094%'  or iduniquebranchsonprod like '00010091%' )   and orders.idorders = :v_idorders ");
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
								

								/// INSERT para SERVIDOR DE peticions :: petitions_server
								$v_id_station = 	$_SESSION["k"]  	 ; //id station for user business
								$iduuff = 	$_SESSION["a"];
								$iduu = 22; /// usuario del servidor
								$v_id_station = 13; // station del servidor;

								$parajson= '{"idorders":'.$vmaxid.'}';
								$sqlpetiti ="INSERT INTO public.fas_petitions_server(
							idpetition, petitiontype, iduserfrom, iduserto, idstationto, instance, date, status, exitstatus, parameters1, parameters2, parameters3, idexterna)
							VALUES ((select COALESCE(max(idpetition),0) + 1 from fas_petitions_server), 2, ".$iduuff.", ".$iduu.", ".$v_id_station.",'04F', now(), 0, null, '".$parajson."', null, null, null);";


								$connect->query($sqlpetiti);
 
								
								/// fin petitions_server para solicitar la generacion de SN
							}
					
					
							$connect->commit();
							/// fin petitions_server
		
					?>


<html>
<p></p>

</html>
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->


<link rel="stylesheet" href="sweetalert2/msweetalert2.min.css">
<script src="sweetalert2/msweetalert2.min.js"></script>

<script>
Swal.fire({
    title: 'SO Saved!',
    icon: 'success',
    showCancelButton: false,
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Ok',

}).then((result) => {
    if (result.value) {
        window.location = "listpresales.php";
    } else {
        window.location = "listpresales.php";
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
.colorfondonaranja {
    border-style: solid;
    border-color: rgba(0, 83, 161, 0.8);
    background-color: rgba(250, 5, 5, 0.4);
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
                        <div class="card-header ui-sortable-handle">

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
                                <a href="listpresales.php" style="color:#0053a1;"><i class='fas fa-search'
                                        style='font-size:24px;color:#0053a1;'></i> &nbsp;List PO</a> &nbsp;&nbsp;
                                <hr>
                            </p>


                            <!-- aca form -->

                            <form action="changeuserfasdata.php" method="post" class="form-horizontal" name="frmpass"
                                id="frmpass">




                            </form>


                            <form action="generarsaleorders.php" method="post" class="form-horizontal" id="myform"
                                name="myform">
                                <!-- NUEVO RENGLON FORM  -->
                                <div class="form-group row">
                                    <label for="statiCustomer" class="col-sm-2 col-form-label">Customer</label>
                                    <div class="col-sm-10">


                                        <select class="js-example-basic-single col-sm-6" id="txtlistcustomers"
                                            name="txtlistcustomers" required onchange="list_po_by_customer(this.value)">
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


                                        &nbsp;&nbsp;<a href="createcustomer.php"><i class='fas fa-user-alt'></i> Add
                                            Customer</a>


                                    </div>
                                </div>
                                <!-- NUEVO RENGLON FORM  -->
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">PO Number</label>
                                    <div class="col-sm-4	">
                                        <?php if ($_REQUEST["add"]=="Y" )
					  {
						  ?> <select class="js-example-basic-single col-sm-6" id="txtponumber" name="txtponumber" required
                                            onchange="list_po_by_customer_andpo(this.value)">
                                            <option value="">Select Customer </option>
                                        </select>
                                        <?php
					  }
					  else
					  { 
						?>
                                        <input type="text" class="form-control" id="txtponumber" name="txtponumber"
                                            onblur="chequearpootrocliente(this.value)" required placeholder="PO Number">
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
						  ?> <select class="js-example-basic-single col-sm-6" id="txtsonumberlu" name="txtsonumberlu" required>
                                            <option value="">Select Customer </option>
                                        </select>
                                        <?php
					  }
					  else
					  { 
						?>

                                        <input type="text" class="form-control" id="txtsonumberlu" name="txtsonumberlu"
                                            required placeholder="SO Number" onblur="chequearso_usado(this.value)">
                                        <?php } ?>





                                    </div>

                                    <div class="col-sm-4">

                                    </div>
                                </div>
                                <!-- NUEVO RENGLON FORM  -->

                                <br>
                                <div class="progress progress-xxs">
                                    <div class="progress-bar progress-bar-danger progress-bar-striped"
                                        role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                        style="width: 100%">
                                    </div>
                                </div>
                                <br>
                                <!-- NUEVO RENGLON FORM  -->
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-1 col-form-label">Ciu Model:</label>
                                    <div class="col-sm-6	">

                                        <select class="js-example-basic-single col-sm-8" required id="txtlistcius"
                                            name="txtlistcius">
                                        </select>

                                        <p id="habilitosupport" name="habilitosupport" class='d-none'>
                                            <a href="https://webfas.honeywell.com/ticketmanagerfiplex.php"> <i
                                                    class="fas fa-question-circle"></i>Require Support</a>
                                        </p>
                                    </div>
                                    <label for="inputPassword" class="col-sm-1 col-form-label">Quantity:</label>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control col-3" id="txtcant" name="txtcant"
                                            data-smk-type="number" min="1" data-validate="true" required
                                            placeholder="quantity" value="1">





                                    </div>



                                    <?php   $psswdtkkey = substr( md5(microtime()), 1, 8); ?>
                                    <input type="hidden" name="tkkeymarco1" id="tkkeymarco1"
                                        value="<?php echo  $psswdtkkey; ?>">


                                    <div class="">
                                        <br>
                                        <button name="btnaddatt1" id="btnaddatt1" type="button"
                                            class="btn btn-sm btn-outline-primary btn-flat "
                                            onclick="openattach(1)">click here to upload files</button>
                                        <hr>
                                        <div class="dropzone dz-clickable ui-sortable" id="myDrop1">
                                            <b> List of attached files:</b><br>
                                            <?php

                                


                              ?>


                                        </div>

                                    </div>

                                    <br>

                                </div>
                                <!-- NUEVO RENGLON FORM  -->
                                <div id="frmwo" name="frmwo">

                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-danger progress-bar-striped"
                                            role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                            style="width: 100%">
                                        </div>
                                    </div>


                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-danger progress-bar-striped"
                                            role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                            style="width: 100%">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-3 col-form-label text-danger">Include
                                            Rabbit Module :</label>
                                        <br>
                                        <div class="col-sm-6	">
                                            <select class="js-example-basic-single col-sm-4" required
                                                id="txthavemodulerabbit" name="txthavemodulerabbit">
                                                <option value="FALSE">NO </option>
                                                <option value="TRUE">YES </option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- NUEVO RENGLON FORM  -->
                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-3 col-form-label">Description:</label>
                                        <div class="col-sm-4	">
                                            <textarea class="form-control" id="txtdescripso" data-validate="false"
                                                name="txtdescripso" rows="4"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-3 col-form-label">Notes PO:</label>
                                        <div class="col-sm-4">
                                            <textarea class="form-control" id="txtnotepo" name="txtnotepo"
                                                data-validate="false" rows="4"></textarea>
                                        </div>
                                    </div>

                                    <!-- div para ocultarle a la lu la carga  -->
                                    <div name="divluciana" id="divluciana" class="d-none">
                                        <!-- NUEVO RENGLON FORM  -->
                                        <div class="form-group row d-none">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">POWER SUPPLY
                                                TYPE:</label>
                                            <div class="col-sm-2">
                                                <select id="txtpwrsupply" name="txtpwrsupply"
                                                    class="custom-select my-1 mr-sm-2 form-control">
                                                    <option value="">-select-</option>
                                                    <option value="AC">AC</option>
                                                    <option value="DC">DC</option>
                                                    <option value="AC/DC">AC/DC</option>


                                                </select>
                                            </div>
                                            <label for="inputPassword" class="col-sm-1 col-form-label d-none">RC-G for
                                                BWA:</label>
                                            <div class="col-sm-1 d-none">

                                                <input type="checkbox" data-toggle="toggle" data-off="NO" data-on="YES"
                                                    id="txtrcgbwa" name="txtrcgbwa">
                                            </div>
                                            <label for="inputPassword" class="col-sm-1 col-form-label d-none">Modem for
                                                Digital:</label>
                                            <div class="col-sm-1 d-none">
                                                <input type="checkbox" data-toggle="toggle" data-on="YES" data-off="NO"
                                                    id="txtmoden" name="txtmoden">


                                            </div>
                                        </div>
                                        <!-- NUEVO RENGLON FORM  -->




                                        <!-- NUEVO RENGLON FORM  -->
                                        <div class="progress progress-xxs">
                                            <div class="progress-bar progress-bar-danger progress-bar-striped"
                                                role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                                aria-valuemax="100" style="width: 100%">
                                            </div>
                                        </div>
                                        <br>




                                        <br>
                                        <!-- NUEVO RENGLON FORM  -->
                                        <div class="form-group row">
                                            <input type="hidden" class="form-control" id="templistadpx"
                                                name="templistadpx">
                                            <div class="col-sm-12">



                                                <div class="col-sm-12" id="listadpx" name="listadpx">
                                                    <table class="table table-striped table-sm ">
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
                                        <div class="progress progress-xxs">
                                            <div class="progress-bar progress-bar-danger progress-bar-striped"
                                                role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                                aria-valuemax="100" style="width: 100%">
                                            </div>
                                        </div>
                                        <br>
                                        <!-- NUEVO RENGLON FORM  -->
                                        <div class="form-group row">



                                            <br><br>


                                            <input type="hidden" id="templistagainuldl" name="templistagainuldl"
                                                value="aaaaa">
                                            <div class="col-sm-12">




                                                <div class="col-sm-12" id="listagainuldl" name="listagainuldl">

                                                </div>
                                                <p align="right">
                                                    <button name="btnadddpx" id="btnadddpx" type="button"
                                                        class="btn btn-sm btn-outline-primary btn-block"
                                                        onclick="add_dpxdiv()">Add DPX </button>
                                                </p>
                                                <div class="container d-none" id="divadddpxmm" name="divadddpxmm">
                                                    <div class="row">
                                                        <table class="table table-striped table-bordered table-sm">
                                                            <tr>
                                                                <td colspan=4>
                                                                    <label>Select Band:</label>
                                                                    <select class="form-control form-control-sm"
                                                                        name="txtnewbanddpx" id="txtnewbanddpx">
                                                                        <option value=""> - Select - </option>
                                                                        <?php
									
							

									$sql = $connect->prepare("select * from idband where active = 'Y' order by description");
									
																			$sql->execute();
																			$resultado3 = $sql->fetchAll();
																			foreach ($resultado3 as $row2) 
																			{
																				
																			?>
                                                                        <option
                                                                            value="<?php echo  $row2['idband']."#".$row2['fstartul']."#".$row2['fstopul']."#".$row2['fstartdl']."#".$row2['fstopdl']."#".$row2['description']; ?>">
                                                                            <?php echo str_pad($row2['description'], 13, "_", STR_PAD_BOTH)." -- [".$row2['fstartul']." / ".$row2['fstopul']."] - [".$row2['fstartdl']." / ".$row2['fstopdl']."]"; ?>
                                                                        </option>
                                                                        <?php
																			}

									?>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <label>DPX Low Start:</label>
                                                                    <input type="number" min="1" class="form-control"
                                                                        placeholder="000.000" name="txtnewdpxlowstart"
                                                                        placeholder=" " id="txtnewdpxlowstart"
                                                                        class="form-control">
                                                                </td>
                                                                <td>
                                                                    <label>DPX Low Stop:</label>
                                                                    <input type="number" min="1" class="form-control"
                                                                        placeholder="000.000" name="txtnewdpxlowstop"
                                                                        placeholder=" " id="txtnewdpxlowstop"
                                                                        class="form-control">
                                                                </td>
                                                                <td>
                                                                    <label>DPX High Start:</label>
                                                                    <input type="number" min="1" class="form-control"
                                                                        placeholder="000.000" name="txtnewdpxhighstart"
                                                                        placeholder=" " id="txtnewdpxhighstart"
                                                                        class="form-control">
                                                                </td>
                                                                <td>
                                                                    <label>DPX High Stop:</label>
                                                                    <input type="number" min="1" class="form-control"
                                                                        placeholder="000.000" name="txtnewdpxhighstop"
                                                                        placeholder=" " id="txtnewdpxhighstop"
                                                                        class="form-control">
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <button name="btnaddchannels3" id="btnaddchannels3" type="button"
                                                        class="btn btn-sm btn-outline-primary btn-flat"
                                                        onclick="addonedpxtolist()">Add DPX to the list </button>
                                                </div>

                                            </div>


                                        </div>

                                        <br>
                                        <!-- NUEVO RENGLON FORM  -->
                                        <div class="form-group row">


                                            <label for="inputPassword" class="col-sm-2 col-form-label">Notes
                                                Dpx:</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="txtnotedpc" name="txtnotedpc"
                                                    data-validate="false" rows="4"></textarea>
                                            </div>
                                        </div>

                                        <div class="progress progress-xxs">
                                            <div class="progress-bar progress-bar-danger progress-bar-striped"
                                                role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                                aria-valuemax="100" style="width: 100%">
                                            </div>
                                        </div>
                                        <br>
                                        <!-- NUEVO RENGLON FORM  -->
                                        <div class="form-group row">


                                            <div class="col-sm-6	">
                                                <label class="col-sm-2 col-form-label">DL Channels (MHz):</label> <input
                                                    type="number" min="1" class="form-control" data-validate="false"
                                                    id="txtchud" name="txtchud" placeholder="000.000">
                                                <label class="col-sm-2 col-form-label">UL Channels (MHz): </label>
                                                <input type="number" min="1" class="form-control" data-validate="false"
                                                    id="txtchul" name="txtchul" placeholder="000.000">
                                                <button name="btnaddchannels" id="btnaddchannels" type="button"
                                                    class="btn btn-smk btn-outline-primary btn-flat"
                                                    onclick="add_channels()">Add to Channel List</button>
                                                <input type="hidden" class="form-control" id="templistchannel"
                                                    name="templistchannel">

                                                <p align="right">
                                                    <button name="btnaddchannels1" id="btnaddchannels1" type="button"
                                                        class="btn btn-sm btn-outline-primary btn-flat"
                                                        onclick="importar_channell()">Import Channel </button>
                                                <div class="container d-none" id="importador" name="importador">
                                                    <div class="row">
                                                        <div class="col"> DL Channels :: copy and paste the channels
                                                            here
                                                            <textarea class="form-control" id="importchdl"
                                                                name="importchdl" rows="2"></textarea>
                                                        </div>
                                                        <div class="col"> UL Channels :: copy and paste the channels
                                                            here
                                                            <textarea class="form-control" id="importchul"
                                                                name="importchul" rows="2"></textarea>
                                                        </div>

                                                    </div>
                                                    <button name="btnaddchannels3" id="btnaddchannels3" type="button"
                                                        class="btn btn-sm btn-outline-primary btn-flat"
                                                        onclick="importar_nowl()">Import now </button>
                                                </div>


                                                </p>

                                            </div>

                                            <div class="col-sm-6">
                                                <div class="col-sm-12" id="listachannel" name="listachannel">
                                                    <table class="table table-striped table-sm ">
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


                                            <label for="inputPassword" class="col-sm-2 col-form-label">Notes
                                                Channel:</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="txtnotechanel" name="txtnotechanel"
                                                    data-validate="false" rows="4"></textarea>
                                            </div>
                                        </div>

                                        <br>
                                        <div class="progress progress-xxs">
                                            <div class="progress-bar progress-bar-danger progress-bar-striped"
                                                role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                                aria-valuemax="100" style="width: 100%">
                                            </div>
                                        </div>
                                        <br>
                                        <!-- NUEVO RENGLON FORM  -->
                                        <div class="form-group row">

                                            <label for="inputPassword" class="col-sm-1 col-form-label">Training required
                                                for PP-ASSY</label>
                                            <div class="col-sm-2">
                                                <input type="checkbox" data-toggle="toggle" data-on="YES" data-off="NO"
                                                    id="txtppassy" name="txtppassy">
                                            </div>
                                            <label for="inputPassword" class="col-sm-1 col-form-label">Training required
                                                for Calibration</label>
                                            <div class="col-sm-2">
                                                <input type="checkbox" data-toggle="toggle" data-on="YES" data-off="NO"
                                                    id="txtreqcalib" name="txtreqcalib">
                                            </div>
                                            <label for="inputPassword" class="col-sm-1 col-form-label">Special Material
                                                required</label>
                                            <div class="col-sm-2">
                                                <input type="checkbox" data-toggle="toggle" data-on="YES" data-off="NO"
                                                    id="txtmatespecial" name="txtmatespecial">
                                            </div>
                                            <label for="inputPassword" class="col-sm-1 col-form-label">Other</label>
                                            <div class="col-sm-2">
                                                <input type="checkbox" data-toggle="toggle" data-on="YES" data-off="NO"
                                                    id="txtotherchange" name="txtotherchange">
                                            </div>
                                        </div>
                                        <!-- NUEVO RENGLON FORM  -->
                                        <!-- NUEVO RENGLON FORM  -->
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">Description of
                                                Resources Required:</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="txtdescripmatesp"
                                                    name="txtdescripmatesp" rows="4"></textarea>

                                            </div>

                                        </div>
                                    </div> <!-- NUEVO RENGLON FORM  -->
                                </div> <!-- fin div lu  -->
                                <div class="form-group row">

                                    <div class="col-sm-10">


                                    </div>
                                    <div class="col-sm-2">
                                        <input type="hidden" name="esdiego" id="esdiego" value="">
                                        <input type="hidden" name="esciu" id="esciu" value="">
                                        <input type="hidden" name="esnamecus" id="esnamecus" value="">
                                        <button type="button" class="btn btn-primary btn-block" id="btnchangepmm"
                                            name="btnchangepmm">Create New PO</button>
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
<link href="css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="js/bootstrap4-toggle.min.js"></script>
<script src="js/bootstrap-typeahead.js"></script>
<script src="js/eModal.min.js" type="text/javascript" />

<script src="js/select2.min.js"></script>
<link rel="stylesheet" href="css/sweetalert2.css">
<script src="js/sweetalert2.min.js"></script>

</body>



<script type="text/javascript">
//variable Global
var vindexarray = 0;
var tabla_cui_cant = [];
var tabla_channel_quantity = [];
var tabla_gain_dlul = [];
var tabla_dpx = [];
var tabla_bandas_paravaludar = [];

tabla_bandas_paravaludar.push({
    idband: 3,
    descband: '700 FirstNet',
    fstartul: parseFloat(788),
    fstopul: parseFloat(805),
    fstartdl: parseFloat(758),
    fstopdl: parseFloat(775)
});
tabla_bandas_paravaludar.push({
    idband: 4,
    descband: '800',
    fstartul: parseFloat(806),
    fstopul: parseFloat(824),
    fstartdl: parseFloat(851),
    fstopdl: parseFloat(869)
});
tabla_bandas_paravaludar.push({
    idband: 0,
    descband: 'VHF',
    fstartul: parseFloat(136),
    fstopul: parseFloat(174),
    fstartdl: parseFloat(136),
    fstopdl: parseFloat(174)
});
tabla_bandas_paravaludar.push({
    idband: 8,
    descband: 'UHF',
    fstartul: parseFloat(450),
    fstopul: parseFloat(512),
    fstartdl: parseFloat(450),
    fstopdl: parseFloat(512)
});
tabla_bandas_paravaludar.push({
    idband: 12,
    descband: 'Band L1',
    fstartul: parseFloat(380),
    fstopul: parseFloat(400),
    fstartdl: parseFloat(380),
    fstopdl: parseFloat(400)
});
tabla_bandas_paravaludar.push({
    idband: 99,
    descband: 'x',
    fstartul: parseFloat(380),
    fstopul: parseFloat(400),
    fstartdl: parseFloat(380),
    fstopdl: parseFloat(400)
});


function soloNumeros(e) {
    var key = window.Event ? e.which : e.keyCode
    return (key >= 48 && key <= 57 || key == 46)
}






function formatRepo(repo) {

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
    $container.find(".select2-result-repository__description").html(repo.description + ' ** ' + repo.link);
    $container.find(".select2-result-repository__forks").append("101" + " Forks");
    $container.find(".select2-result-repository__stargazers").append("102" + " Stars");
    $container.find(".select2-result-repository__watchers").append("103" + " Watchers");
    //  console.log(repo.text);
    return $container;
}

function formatRepoSelection(repo) {
    // console.log('1' + repo.text);
    return repo.full_name || repo.text;
}


$(document).ready(function() {


    $('.js-example-basic-single').select2();
    $('#esdiego').val("0");

    $("#txtlistcius").change(function() {
        var tabla_info_show_po = "";

        //Limpiamos Array de CH UNI DPX	

        //console.log(tabla_channel_quantity.length);
        tabla_channel_quantity.length = 0;
        tabla_gain_dlul.length = 0;
        tabla_dpx.length = 0;


        $.ajax({
            url: 'checksousadowo.php',
            data: "idproduct=" + $("#txtlistcius").val(),
            type: 'post',
            datatype: 'JSON',
            success: function(data) {
                //	console.log(data.woparam);
                // console.log (data.woparam);

                if (data.haveconfiguration > 0) {

                    $("#habilitosupport").addClass('d-none');
                    $("#btnchangepmm").removeClass('d-none');
                    if (data.woparam == false) {
                        $("#frmwo").addClass('d-none');
                    } else {
                        $("#frmwo").removeClass('d-none');
                        //PRECARGAMOS
                        if (data.powersupply == "AC") {
                            document.getElementById("txtpwrsupply").selectedIndex = 1;
                        }
                        if (data.powersupply == "DC") {
                            document.getElementById("txtpwrsupply").selectedIndex = 2;
                        }
                        if (data.powersupply == "AC/DC") {
                            document.getElementById("txtpwrsupply").selectedIndex = 3;
                        }
                        /*  $("#txtdlgain").val(data.dlgain);
                        $("#txtdlmaxpwr").val(data.dlmaxpwr);
                        $("#txtulgain").val(data.ulgain);
                        $("#txtulmaxpwr").val(data.ulmaxpwr);*/

                        if (parseFloat(data.ulgain) == 9999) {
                            //	alert('CIU ERROR');
                            $("#habilitosupport").removeClass('d-none');


                            //	btnchangepmm
                            $("#btnchangepmm").addClass('d-none');
                            alert(
                                'the CIU does not have the configuration parameters for FAS'
                            );
                        }
                        if (parseFloat(data.dlgain) == 9999) {
                            //	alert('CIU ERROR');
                            $("#habilitosupport").removeClass('d-none');


                            //	btnchangepmm
                            $("#btnchangepmm").addClass('d-none');
                            alert(
                                'the CIU does not have the configuration parameters for FAS'
                            );
                        }
                        if (parseFloat(data.ulmaxpwr) == 9999) {
                            //	alert('CIU ERROR');
                            $("#habilitosupport").removeClass('d-none');


                            //	btnchangepmm
                            ///$("#btnchangepmm").addClass('d-none');
                            //alert('the CIU does not have the configuration parameters for FAS');
                            //comentado para remotoss
                        }
                        if (parseFloat(data.dlmaxpwr) == 9999) {
                            //	alert('CIU ERROR');
                            $("#habilitosupport").removeClass('d-none');


                            //	btnchangepmm
                            //	$("#btnchangepmm").addClass('d-none');
                            //comentado para master

                        }

                        var v_gain_ul = parseFloat(data.ulgain);
                        var v_gain_dl = parseFloat(data.dlgain);
                        var v_maxpwr_ul = parseFloat(data.ulmaxpwr);
                        var v_maxpwr_dl = parseFloat(data.dlmaxpwr);
                        /* a pedido de lea par TEST
                        	$("#btnlist_gain").addClass('d-none'); 
                        	$("#btnlist_dpx").addClass('d-none'); 
                        	$("#btnaddchannels").addClass('d-none'); 
                        	*/

                        tabla_info_show_wo = "<table class='table table-striped '><tbody>";
                        tabla_info_show_po = tabla_info_show_po +
                            "<tr><th><b>UNIT (DL - UL) List</b></th><td></td><td></td><td></td></tr>";
                        var note_unit = "";
                        $.each(data.arr_dpxunit, function(i, itempsunit) {
                            note_unit = itempsunit.nomband;
                            tabla_info_show_po = tabla_info_show_po + "<tr><td>" +
                                note_unit + " Unit DL: Start: <b>" + itempsunit
                                .fstartdl + "</b> MHz</td><td>Unit DL: Stop: <b>" +
                                itempsunit.fstopdl +
                                "</b> MHz</td><td>Unit UL: Start: <b>" + itempsunit
                                .fstartul + "</b> MHz</td> <td>Unit UL: Stop: <b>" +
                                itempsunit.fstopul + "</b> MHz</td></tr>";

                            if (itempsunit.nomband.indexOf('700') >= 0 || itempsunit
                                .nomband.indexOf('800') >= 0) {
                                tabla_gain_dlul.push({
                                    Band: itempsunit.nomband,
                                    hiddengainudstart: parseFloat(itempsunit
                                        .fstartdl),
                                    hiddengainudstop: parseFloat(itempsunit
                                        .fstopdl),
                                    hiddengainulstart: parseFloat(itempsunit
                                        .fstartul),
                                    hiddengainulstop: parseFloat(itempsunit
                                        .fstopul),
                                    DL_Start: parseFloat(itempsunit
                                        .fstartdl),
                                    DL_Stop: parseFloat(itempsunit.fstopdl),
                                    UL_Start: parseFloat(itempsunit
                                        .fstartul),
                                    UL_Stop: parseFloat(itempsunit.fstopul),
                                    noteditUL_gain: parseFloat(v_gain_ul),
                                    noteditDL_gain: parseFloat(v_gain_dl),
                                    noteditUL_maxpwr: parseFloat(
                                        v_maxpwr_ul),
                                    noteditDL_maxpwr: parseFloat(
                                        v_maxpwr_dl)
                                });

                                tabla_dpx.push({
                                    Band: itempsunit.nomband,
                                    dpxlowstart: parseFloat(itempsunit
                                        .fstartdl),
                                    dpxlowstop: parseFloat(itempsunit
                                        .fstopdl),
                                    dpxhighstart: parseFloat(itempsunit
                                        .fstartul),
                                    dpxhighstop: parseFloat(itempsunit
                                        .fstopul),
                                    dpxlowstartcustom: parseFloat(itempsunit
                                        .fstartdl),
                                    dpxlowstopcustom: parseFloat(itempsunit
                                        .fstopdl),
                                    dpxhighstartcustom: parseFloat(
                                        itempsunit.fstartul),
                                    dpxhighstopcustom: parseFloat(itempsunit
                                        .fstopul),
                                    isfullband: itempsunit.isfullband,
                                    qband: 1,
                                    idarray: vindexarray

                                });

                                vindexarray = vindexarray + 1;
                                console.log('ssssssssssssssssssssssssssss');

                                for (var imm = 1; imm < itempsunit
                                    .cantsubband; imm++) {
                                    tabla_dpx.push({
                                        Band: itempsunit.nomband,
                                        dpxlowstart: parseFloat(itempsunit
                                            .fstartdl),
                                        dpxlowstop: parseFloat(itempsunit
                                            .fstopdl),
                                        dpxhighstart: parseFloat(itempsunit
                                            .fstartul),
                                        dpxhighstop: parseFloat(itempsunit
                                            .fstopul),
                                        dpxlowstartcustom: parseFloat(
                                            itempsunit.fstartdl),
                                        dpxlowstopcustom: parseFloat(
                                            itempsunit.fstopdl),
                                        dpxhighstartcustom: parseFloat(
                                            itempsunit.fstartul),
                                        dpxhighstopcustom: parseFloat(
                                            itempsunit.fstopul),
                                        isfullband: itempsunit.isfullband,
                                        qband: 1,
                                        idarray: vindexarray

                                    });
                                }
                            } else {
                                tabla_gain_dlul.push({
                                    Band: itempsunit.nomband,
                                    hiddengainudstart: parseFloat(itempsunit
                                        .fstartdl),
                                    hiddengainudstop: parseFloat(itempsunit
                                        .fstopdl),
                                    hiddengainulstart: parseFloat(itempsunit
                                        .fstartul),
                                    hiddengainulstop: parseFloat(itempsunit
                                        .fstopul),
                                    DL_Start: parseFloat(0),
                                    DL_Stop: parseFloat(0),
                                    UL_Start: parseFloat(0),
                                    UL_Stop: parseFloat(0),
                                    noteditUL_gain: parseFloat(v_gain_ul),
                                    noteditDL_gain: parseFloat(v_gain_dl),
                                    noteditUL_maxpwr: parseFloat(
                                        v_maxpwr_ul),
                                    noteditDL_maxpwr: parseFloat(
                                        v_maxpwr_dl)
                                });

                                tabla_dpx.push({
                                    Band: itempsunit.nomband,
                                    dpxlowstart: parseFloat(itempsunit
                                        .fstartdl),
                                    dpxlowstop: parseFloat(itempsunit
                                        .fstopdl),
                                    dpxhighstart: parseFloat(itempsunit
                                        .fstartul),
                                    dpxhighstop: parseFloat(itempsunit
                                        .fstopul),
                                    dpxlowstartcustom: parseFloat(itempsunit
                                        .fstartdl),
                                    dpxlowstopcustom: parseFloat(itempsunit
                                        .fstopdl),
                                    dpxhighstartcustom: parseFloat(
                                        itempsunit.fstartul),
                                    dpxhighstopcustom: parseFloat(itempsunit
                                        .fstopul),
                                    isfullband: itempsunit.isfullband,
                                    qband: 1,
                                    idarray: vindexarray
                                });


                                vindexarray = vindexarray + 1;

                                for (var imm = 1; imm < itempsunit
                                    .cantsubband; imm++) {

                                    tabla_dpx.push({
                                        Band: itempsunit.nomband,
                                        dpxlowstart: parseFloat(itempsunit
                                            .fstartdl),
                                        dpxlowstop: parseFloat(itempsunit
                                            .fstopdl),
                                        dpxhighstart: parseFloat(itempsunit
                                            .fstartul),
                                        dpxhighstop: parseFloat(itempsunit
                                            .fstopul),
                                        dpxlowstartcustom: 0,
                                        dpxlowstopcustom: 0,
                                        dpxhighstartcustom: 0,
                                        dpxhighstopcustom: 0,
                                        isfullband: itempsunit.isfullband,
                                        qband: 1,
                                        idarray: vindexarray
                                    });




                                }

                            }



                        });


                        tabla_gain_udul2dagen();
                        list_tabla_dpx_udul2dagen();




                    }

                } else {



                    toastr["error"](
                        "the CIU does not have the configuration parameters for FAS",
                        "CIU not configured");
                    $("#habilitosupport").removeClass('d-none');


                    //	btnchangepmm
                    $("#btnchangepmm").addClass('d-none');
                    alert('the CIU does not have the configuration parameters for FAS');
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
            data: function(params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function(data) {
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: data.items
                };
            },
            cache: false
        },
        placeholder: 'Search CIU',
        minimumInputLength: 1,
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });

    // fin// AutoComplete de CUIS version TOP

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
    })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', {
        'placeholder': 'mm/dd/yyyy'
    })
    //Money Euro
    $('[data-mask]').inputmask()

    //Inicio mostrar hora live
    var interval = setInterval(function() {

        var momentNow = moment();
        var newYork = momentNow.tz('America/New_York').format('ha z');
        $('#date-part').html(momentNow.format('YYYY-MM-DD'));
        $('#time-part').html(momentNow.format('hh:mm:ss'));
        $('#dyhya').val(momentNow.format('YYYY-MM-DD') + ' ' + momentNow.format('hh:mm:ss'));
    }, 100);
    //FIN mostrar hora live
    console.log("ready!");


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


    ///Alert():		
    //	console.log('fin0')	;
    // recuperamos el querystring
    const querystring = window.location.search
    //	console.log(querystring) // '?q=pisos+en+barcelona&ciudad=Barcelona'

    // usando el querystring, creamos un objeto del tipo URLSearchParams
    const params = new URLSearchParams(querystring)
    const paramsmarco = new URLSearchParams(querystring)
    //	console.log(params.get('pre'));

    ///OJO
    $('#divluciana').removeClass('d-none');
    if (params.get('pre') == 'Y') {
        ///precargamos valores
        $('#txtlistcustomers').val(params.get('idcus'));
        $('#txtlistcustomers').trigger('change');

        $('#txtponumber').val(params.get('po'));

        $('#txtsonumberlu').val(params.get('so'));
        $('#txtcant').val(params.get('qq'));

        $('#divluciana').removeClass('d-none');
        var aamm = params.get('ciu');

        var datamm = {
            id: params.get('idciu'),
            text: params.get('ciu')
        };

        var newOption = new Option(datamm.text, datamm.id, false, false);
        $('#txtlistcius').append(newOption).trigger('change');

        ///PRECARGADOR

        $('#txtlistcius').val(params.get('idciu'));
        //	$('#txtlistcius').trigger('change');
        $('#esdiego').val(params.get('idso')); // idso

        $('#esnamecus').val($('#txtlistcustomers option:selected').html()); // idso
        $('#esciu').val($('#txtlistcius option:selected').html()); // idso



    }

});



// controlar inactividad en la web	
$(document).inactivityTimeout({
    inactivityWait: 100000,
    dialogWait: 10,
    logoutUrl: 'logout.php'
})
// fin controlar inactividad en la web		

/* requesting data */
function borrar_array_channel(idborrarch) {
    tabla_channel_quantity.splice(idborrarch, 1);

    $('body,html').stop(true, true).animate({
        scrollTop: $("#listachannel").offset().top
    }, 1);

    tabla_channels();
    $('body,html').stop(true, true).animate({
        scrollTop: $("#listachannel").offset().top
    }, 1);
}

function borrar_array_uldl(idborrarch) {
    tabla_gain_dlul.splice(idborrarch, 1);

    $('body,html').stop(true, true).animate({
        scrollTop: $("#listagainuldl").offset().top
    }, 1);

    tabla_gain_udul2dagen();
    $('body,html').stop(true, true).animate({
        scrollTop: $("#listagainuldl").offset().top
    }, 1);
}

function borrar_array_dpx(idborrarch) {
    // tabla_gain_dlul.splice(idborrarch, 1); 
    tabla_dpx.splice(idborrarch, 1);

    $('body,html').stop(true, true).animate({
        scrollTop: $("#listadpx").offset().top
    }, 1);


    list_tabla_dpx_udul2dagen();
    $('body,html').stop(true, true).animate({
        scrollTop: $("#listadpx").offset().top
    }, 1);
}

function borrar_array(idborrar) {

    tabla_cui_cant.splice(idborrar, 1);

    var html = '<table class="table  table-striped table-sm ">';
    html += '<tr>';
    var cantcabez = tabla_cui_cant[0];
    for (var j in cantcabez) {
        html += '<th>' + j + '</th>';
        if (j === 'cant') {
            html += '<th>Action</th>';
            break;
        }
    }
    html += '</tr>';
    for (var i = 0; i < tabla_cui_cant.length; i++) {
        html += '<tr>';
        for (var j in tabla_cui_cant[i]) {
            if ('idcui' != j) {
                html += '<td>' + tabla_cui_cant[i][j] + '</td>';
            }

        }
        html += '<td>  <a href="#" onclick="borrar_array(' + i + ')"> <i class="fas fa-trash-alt"></i> Del</a> </td>';
        html += '</tr>';
    }
    html += '</table>';

    // console.log(html);
    $('#listacium').html(html);

}

function addonedpxtolist() {

    Number.prototype.between = function(a, b, inclusive) {
        var min = Math.min(a, b),
            max = Math.max(a, b);

        return inclusive ? this >= min && this <= max : this > min && this < max;
    }



    /// Validamossss
    if ($("#txtnewbanddpx").val() == '') {
        alert('you must select a DPX band');
    } else {
        var res = $("#txtnewbanddpx").val();
        var splitbandselect = res.split("#");
        //////controlamos las bandas
        var todoscompletos = 0;
        if ($("#txtnewdpxlowstart").val() == 0) {
            todoscompletos = 1;
        }
        if ($("#txtnewdpxlowstop").val() == 0) {
            todoscompletos = 1;
        }
        if ($("#txtnewdpxhighstart").val() == 0) {
            todoscompletos = 1;
        }
        if ($("#txtnewdpxhighstop").val() == 0) {
            todoscompletos = 1;
        }

        if (todoscompletos == 0) {
            var elvalor_dpxlowstart = parseFloat($("#txtnewdpxlowstart").val());
            var elvalor_dpxlowstop = parseFloat($("#txtnewdpxlowstop").val());
            //console.log(elvalor_dpxlowstart.between( parseFloat (splitbandselect[1]) , parseFloat (splitbandselect[2]),true) );

            if ((elvalor_dpxlowstart.between(parseFloat(splitbandselect[1]), parseFloat(splitbandselect[2]), true)) && (
                    elvalor_dpxlowstop.between(parseFloat(splitbandselect[1]), parseFloat(splitbandselect[2]), true))) {
                var elvalor_dpxhighstart = parseFloat($("#txtnewdpxhighstart").val());
                var elvalor_dpxhighstop = parseFloat($("#txtnewdpxhighstop").val());
                if ((elvalor_dpxhighstart.between(parseFloat(splitbandselect[3]), parseFloat(splitbandselect[4]),
                        true)) && (elvalor_dpxhighstop.between(parseFloat(splitbandselect[3]), parseFloat(
                        splitbandselect[
                            4]), true))) {
                    vindexarray = vindexarray + 1;
                    tabla_dpx.push({
                        Band: splitbandselect[5],
                        dpxlowstart: parseFloat(splitbandselect[1]),
                        dpxlowstop: parseFloat(splitbandselect[2]),
                        dpxhighstart: parseFloat(splitbandselect[3]),
                        dpxhighstop: parseFloat(splitbandselect[4]),
                        dpxlowstartcustom: parseFloat($("#txtnewdpxlowstart").val()),
                        dpxlowstopcustom: parseFloat($("#txtnewdpxlowstop").val()),
                        dpxhighstartcustom: parseFloat($("#txtnewdpxhighstart").val()),
                        dpxhighstopcustom: parseFloat($("#txtnewdpxhighstop").val()),
                        isfullband: 'show',
                        qband: 1,
                        idarray: vindexarray
                    });
                    // limpiamosss
                    $("#txtnewdpxlowstart").val('');
                    $("#txtnewdpxlowstop").val('');
                    $("#txtnewdpxhighstart").val('');
                    $("#txtnewdpxhighstop").val('');
                    $("#divadddpxmm").addClass('d-none');
                    list_tabla_dpx_udul2dagen();
                } else {
                    alert('HIGH :Out of range');
                }
            } else {
                //	alert('LOW :Out of range');
                vindexarray = vindexarray + 1;
                tabla_dpx.push({
                    Band: splitbandselect[5],
                    dpxlowstart: parseFloat(splitbandselect[1]),
                    dpxlowstop: parseFloat(splitbandselect[2]),
                    dpxhighstart: parseFloat(splitbandselect[3]),
                    dpxhighstop: parseFloat(splitbandselect[4]),
                    dpxlowstartcustom: parseFloat($("#txtnewdpxlowstart").val()),
                    dpxlowstopcustom: parseFloat($("#txtnewdpxlowstop").val()),
                    dpxhighstartcustom: parseFloat($("#txtnewdpxhighstart").val()),
                    dpxhighstopcustom: parseFloat($("#txtnewdpxhighstop").val()),
                    isfullband: 'show',
                    qband: 1,
                    idarray: vindexarray
                });
                // limpiamosss
                $("#txtnewdpxlowstart").val('');
                $("#txtnewdpxlowstop").val('');
                $("#txtnewdpxhighstart").val('');
                $("#txtnewdpxhighstop").val('');
                $("#divadddpxmm").addClass('d-none');
                list_tabla_dpx_udul2dagen();
            }




        } else {
            alert('you must enter the values ​​for the DPX');
        }

    }







}


function tabla_channels() {
    var jname = "";
    var v_templistchannel = "";
    var html = '<table class="table  table-striped table-sm ">';
    html += '<tr>';
    var cantcabez = tabla_channel_quantity[0];

    for (var j in cantcabez) {

        jname = j
        if (j == 'channeldl') {
            jname = "DL Channels (MHz)";
        }
        if (j == 'channelul') {
            jname = "UL Channels (MHz)";
        }
        if (j == 'idband') {
            jname = "Band";
        }

        html += '<th>' + jname + '</th>';

    }
    html += '<th>Action</th>';
    html += '</tr>';
    for (var i = 0; i < tabla_channel_quantity.length; i++) {
        html += '<tr>';

        if (v_templistchannel != '') {
            v_templistchannel = v_templistchannel + "#";
        }

        for (var j in tabla_channel_quantity[i]) {

            if (j == 'idband') {
                html += '<td>' + tabla_bandas_paravaludar.find(x => x.idband === tabla_channel_quantity[i][j])
                    .descband + ' </td>';
                //	tabla_bandas_paravaludar

            } else {
                html += '<td>' + tabla_channel_quantity[i][j] + '  MHz</td>';
            }

            v_templistchannel = v_templistchannel + tabla_channel_quantity[i][j] + "|"


        }
        html += '<td>  <a href="#" onclick="borrar_array_channel(' + i +
            ')"> <i class="fas fa-trash-alt"></i> Del</a> </td>';
        html += '</tr>';
    }
    html += '</table>';
    v_templistchannel = v_templistchannel + "#";
    //	 console.log(v_templistchannel);
    $('#listachannel').html(html);
    $('#templistchannel').val(v_templistchannel);

}

function isBoolean(val) {
    return val === false || val === true;
}

function list_tabla_dpx_udul2dagen() {
    var jname = "";
    var v_temp_dpx = "";

    var mindpxstartLOW = 99999;
    var mindpxstopLOW = 0;
    var mindpxstartHIGH = 99999;
    var mindpxstopHIGH = 0;

    var htmlmejoradodpx =
        '	<table class="table table-striped table-bordered table-sm"><thead >    <tr ><th class="table-dark text-center" scope="col">#</th> <th class="table-primary text-center" colspan=2 scope="col">DOWNLINK </th><th  class="table-info text-center" colspan=2 scope="col">UPLINK </th> </tr>';
    htmlmejoradodpx +=
        '<tr> <th width="100px"  class="table-dark text-center"  style="width: 10px">Band</th> <th  class="table-primary text-center" >DPX Low Start </th> <th  class="table-primary text-center" >DPX Low Stop </th><th  class="table-info text-center" >DPX High Start </th><th  class="table-info text-center" >DPX High Stop </th> </tr> </thead> <tbody>';

    for (var i = 0; i < tabla_dpx.length; i++) {
        //	console.log(tabla_dpx[0]);
        var v_temp_DL_Start = '';
        var v_temp_DL_Startclass = '';


        if (tabla_dpx[i].Band.indexOf('700') >= 0 || tabla_dpx[i].Band.indexOf('800') >= 0) {
            htmlmejoradodpx += '<tr><th width="100px" scope="row">' + tabla_dpx[i].Band +
                '</th>	<td  width="150px" class=" text-center  id' + i + '#dpxhighstart' + '" id="id' + i +
                '#dpxhighstart" onkeypress="return soloNumeros(event)"  onblur="modif_table_array(' + "'id" + i +
                '#dpxhighstart' + "'" + ',' + i + ')" >' + tabla_dpx[i].dpxlowstartcustom +
                ' MHz</td>	<td width="150px" class=" text-center  id' + i + '#dpxhighstop' + '" id="id' + i +
                '#dpxhighstop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array(' + "'id" + i +
                '#dpxhighstop' + "'" + ',' + i + ')" >' + tabla_dpx[i].dpxlowstopcustom + ' MHz</td>';
            htmlmejoradodpx += '<td  width="150px" class=" text-center  id' + i + '#dpxlowstart' + '" id="id' + i +
                '#dpxlowstart" onkeypress="return soloNumeros(event)"  onblur="modif_table_array(' + "'id" + i +
                '#dpxlowstart' + "'" + ',' + i + ')" >' + tabla_dpx[i].dpxhighstartcustom +
                ' MHz</td>	<td width="150px" class=" text-center  id' + i + '#dpxlowstop' + '" id="id' + i +
                '#dpxlowstop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array(' + "'id" + i +
                '#dpxlowstop' + "'" + ',' + i + ')" >' + tabla_dpx[i].dpxhighstopcustom + ' MHz</td>';

        } else {
            v_temp_dpxlowstartcustom = '';
            v_temp_dpxlowstartcustomclass = 'colorfondonaranja';
            //	console.log('tabla_dpx[i].dpxlowstartcustom:'+tabla_dpx[i].dpxlowstartcustom);
            ///console.log('a Ver es full band'+ tabla_dpx[i].isfullband + '+--------'+ isBoolean( tabla_dpx[i].isfullband)  );
            if (tabla_dpx[i].isfullband === true) {
                v_temp_dpxlowstartcustom = tabla_dpx[i].dpxlowstart + ' MHz';
                v_temp_dpxlowstartcustomclass = '';
                mindpxstartLOW = tabla_dpx[i].dpxlowstart;
            }
            if (tabla_dpx[i].isfullband == 'show') {
                v_temp_dpxlowstartcustom = tabla_dpx[i].dpxlowstartcustom + ' MHz';
                v_temp_dpxlowstartcustomclass = '';
                mindpxstartLOW = tabla_dpx[i].dpxlowstartcustom;
            }
            /*	if (tabla_dpx[i].dpxlowstartcustom!=0)
            	{
            		v_temp_dpxlowstartcustom=tabla_dpx[i].dpxlowstartcustom + ' MHz';
            		v_temp_dpxlowstartcustomclass='';
            		if ( mindpxstartLOW > tabla_dpx[i].dpxlowstartcustom)
            		{
            			mindpxstartLOW=tabla_dpx[i].dpxlowstartcustom;
            		}
            	}*/

            v_temp_dpxlowstopcustom = '';
            v_temp_dpxlowstopcustomomclass = 'colorfondonaranja';
            if (tabla_dpx[i].isfullband === true) {
                v_temp_dpxlowstopcustom = tabla_dpx[i].dpxlowstop + ' MHz';
                v_temp_dpxlowstopcustomomclass = '';
                mindpxstopLOW = tabla_dpx[i].dpxlowstop;
            }

            if (tabla_dpx[i].isfullband == 'show') {
                v_temp_dpxlowstopcustom = tabla_dpx[i].dpxlowstopcustom + ' MHz';
                v_temp_dpxlowstopcustomomclass = '';
                mindpxstopLOW = tabla_dpx[i].dpxlowstopcustom;
            }
            /*		if (tabla_dpx[i].dpxlowstopcustom!=0)
            			{
            				v_temp_dpxlowstopcustom=tabla_dpx[i].dpxlowstopcustom + ' MHz';
            				v_temp_dpxlowstopcustomomclass='';
            				if ( mindpxstopLOW < tabla_dpx[i].dpxlowstopcustom)
            				{
            					mindpxstopLOW=tabla_dpx[i].dpxlowstopcustom;
            				}
            			}*/

            v_temp_dpxhighstartcustom = '';
            v_temp_dpxhighstartcustomclass = 'colorfondonaranja';
            if (tabla_dpx[i].isfullband === true) {
                v_temp_dpxhighstartcustom = tabla_dpx[i].dpxhighstart + ' MHz';
                v_temp_dpxhighstartcustomclass = '';
                mindpxstartHIGH = tabla_dpx[i].dpxhighstart;
            }
            if (tabla_dpx[i].isfullband == 'show') {
                v_temp_dpxhighstartcustom = tabla_dpx[i].dpxhighstartcustom + ' MHz';
                v_temp_dpxhighstartcustomclass = '';
                mindpxstartHIGH = tabla_dpx[i].dpxhighstartcustom;
            }

            /*		if (tabla_dpx[i].dpxhighstartcustom!=0)
            			{
            				v_temp_dpxhighstartcustom=tabla_dpx[i].dpxhighstartcustom + ' MHz';
            				v_temp_dpxhighstartcustomclass='';
            				if ( mindpxstartHIGH > tabla_dpx[i].dpxhighstartcustom)
            				{
            					mindpxstartHIGH=tabla_dpx[i].dpxhighstartcustom;
            				}
            			}*/

            v_temp_dpxhighstopcustom = '';
            v_temp_dpxhighstopcustomclass = 'colorfondonaranja';
            if (tabla_dpx[i].isfullband === true) {
                v_temp_dpxhighstopcustom = tabla_dpx[i].dpxhighstop + ' MHz';
                v_temp_dpxhighstopcustomclass = '';
                mindpxstopHIGH = tabla_dpx[i].dpxhighstop;
            }
            if (tabla_dpx[i].isfullband == 'show') {
                v_temp_dpxhighstopcustom = tabla_dpx[i].dpxhighstopcustom + ' MHz';
                v_temp_dpxhighstopcustomclass = '';
                mindpxstopHIGH = tabla_dpx[i].dpxhighstopcustom;
            }

            /*	if (tabla_dpx[i].dpxhighstopcustom!=0)
						{
							v_temp_dpxhighstopcustom=tabla_dpx[i].dpxhighstopcustom + ' MHz';
							v_temp_dpxhighstopcustomclass='';
							if ( mindpxstopHIGH < tabla_dpx[i].dpxhighstopcustom)
							{
								mindpxstopHIGH=tabla_dpx[i].dpxhighstopcustom;
							}
						}
*/

            for (var immxx = 0; immxx < tabla_dpx[i].qband; immxx++) {
                //////<a href="#" onclick="OJOborrar_array_dpx('+imm+')" title="Delete the DPX"><i class="fas fa-times-circle"></i></a>  no dejo borrar mas
                imm = tabla_dpx[i].idarray;
                htmlmejoradodpx += '<tr><th width="100px" scope="row"> ' + tabla_dpx[i].Band +
                    '   &nbsp;&nbsp;   </th>';
                htmlmejoradodpx += '<td  width="150px"  contenteditable="true" class=" text-center ' +
                    v_temp_dpxlowstartcustomclass + '  id' + imm + '#dpxlowstartcustom' + '" id="id' + imm +
                    '#dpxlowstartcustom" onkeypress="return soloNumeros(event)"  onblur="modif_table_arraydpx(' +
                    "'id" + imm + '#dpxlowstartcustom' + "'" + ',' + imm + ')" >' + v_temp_dpxlowstartcustom + ' </td>';
                htmlmejoradodpx += '	<td width="150px"   contenteditable="true" class=" text-center ' +
                    v_temp_dpxlowstopcustomomclass + '  id' + imm + '#dpxlowstopcustom' + '" id="id' + imm +
                    '#dpxlowstopcustom" onkeypress="return soloNumeros(event)"  onblur="modif_table_arraydpx(' + "'id" +
                    imm + '#dpxlowstopcustom' + "'" + ',' + imm + ')" >' + v_temp_dpxlowstopcustom + ' </td>';
                htmlmejoradodpx += '<td  width="150px" contenteditable="true" class=" text-center ' +
                    v_temp_dpxhighstartcustomclass + '  id' + imm + '#dpxhighstartcustom' + '" id="id' + imm +
                    '#dpxhighstartcustom" onkeypress="return soloNumeros(event)"  onblur="modif_table_arraydpx(' +
                    "'id" + imm + '#dpxhighstartcustom' + "'" + ',' + imm + ')" >' + v_temp_dpxhighstartcustom +
                    ' </td>';
                htmlmejoradodpx += '<td width="150px"  contenteditable="true" class=" text-center ' +
                    v_temp_dpxhighstopcustomclass + '  id' + imm + '#dpxhighstopcustom' + '" id="id' + imm +
                    '#dpxhighstopcustom" onkeypress="return soloNumeros(event)"  onblur="modif_table_arraydpx(' +
                    "'id" + imm + '#dpxhighstopcustom' + "'" + ',' + imm + ')" >' + v_temp_dpxhighstopcustom + ' </td>';

            }


            /// AutoFill a las Unit


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

        mindpxstartLOW = 99999;
        mindpxstopLOW = 0;
        mindpxstartHIGH = 99999;
        mindpxstopHIGH = 0;

    }
    htmlmejoradodpx += ' </tbody></table>'
    var html = '<table class="table  table-striped table-sm ">';
    html += '<tr>';
    var cantcabez = tabla_dpx[0];

    for (var j in cantcabez) {
        jname = j
        if (j == 'dpxlowstart') {
            jname = 'DPX Low Start';
        }
        if (j == 'dpxlowstop') {
            jname = 'DPX Low Stop';
        }
        if (j == 'dpxhighstart') {
            jname = 'DPX High Start';
        }
        if (j == 'dpxhighstop') {
            jname = 'DPX High Stop';
        }


        html += '<th>' + jname + '</th>';

    }
    html += '<th>Action</th>';
    html += '</tr>';
    for (var i = 0; i < tabla_dpx.length; i++) {
        html += '<tr>';

        if (v_temp_dpx != '') {
            v_temp_dpx = v_temp_dpx + "#";
        }

        for (var j in tabla_dpx[i]) {

            if ('UNKNOW' == tabla_dpx[i][j]) {
                html += '<td>' + tabla_dpx[i][j] + ' </td>';
            } else {
                if (j == 'Band') {
                    html += '<td>' + tabla_dpx[i][j] + ' </td>';
                } else {
                    html += '<td>' + tabla_dpx[i][j] + ' MHz</td>';
                }
            }
            ///html += '<td>' + tabla_dpx[i][j]  +' MHz</td>';	  
            v_temp_dpx = v_temp_dpx + tabla_dpx[i][j] + "|"


        }
        html += '<td>  <a href="#" onclick="borrar_array_dpx(' + i +
            ')"> <i class="fas fa-trash-alt"></i> Del</a> </td>';
        html += '</tr>';
    }
    html += '</table>';
    v_temp_dpx = v_temp_dpx + "#";
    //		 console.log(v_temp_dpx);
    /// variable html no usar mas es html viejoo
    ///$('#listadpx').html(html+'<br><br>'+htmlmejoradodpx);
    $('#listadpx').html(htmlmejoradodpx);
    $('#templistadpx').val(v_temp_dpx);
}


function openattach(iddivsearch) {

    var seed_associed = $("#tkkeymarco" + iddivsearch).val();

    var vv_idp = $("#projectdraft").val();
    var vv_idprev = $("#projectdraftrev").val();
    //console.log(seed_associed);



    eModal.iframe('attachfileprojectso.php?idt=' + seed_associed + '&idp=' + vv_idp + '&idpr=' + vv_idprev +
        '&openattach=' + iddivsearch, 'Attach files to SO	  ');

    setTimeout('controlattach(' + iddivsearch + ')', 1000);


}



function tabla_gain_udul2dagen() {


}

function modif_table_arraydpx(lacelda, valorcelda) {
    var losdatosaupatar = lacelda.split("#");

    ///document.getElementsByClassName("id0#DL_Start")[0].innerHTML;
    var aaaobte = document.getElementsByClassName(lacelda)[0].innerHTML;
    var aaapbtelimpio = aaaobte.replace('MHz', '');
    console.log('ac');
    console.log(aaapbtelimpio);
    if ($.isNumeric(aaapbtelimpio)) {

        //		console.log(	tabla_dpx[valorcelda].dpxhighstart);
        //		console.log(	tabla_dpx[valorcelda].dpxhighstop);

        //		console.log(	tabla_dpx[valorcelda].dpxlowstart);
        //		console.log(	tabla_dpx[valorcelda].dpxlowstop);

        console.log(lacelda);
        console.log(valorcelda);

        if (losdatosaupatar[1] == 'dpxhighstartcustom' || losdatosaupatar[1] == 'dpxhighstopcustom') {
            if (parseFloat(tabla_dpx[valorcelda].dpxhighstart) <= parseFloat(aaapbtelimpio) && parseFloat(tabla_dpx[
                    valorcelda].dpxhighstop) >= parseFloat(aaapbtelimpio)) {
                tabla_dpx[valorcelda][losdatosaupatar[1]] = aaapbtelimpio;
                tabla_dpx[valorcelda].isfullband = 'show';
            } else {
                alert('HIGH::out of range');

                tabla_dpx[valorcelda][losdatosaupatar[1]] = '';
            }
        }
        if (losdatosaupatar[1] == 'dpxlowstartcustom' || losdatosaupatar[1] == 'dpxlowstopcustom') {
            if (parseFloat(tabla_dpx[valorcelda].dpxlowstart) <= parseFloat(aaapbtelimpio) && parseFloat(tabla_dpx[
                    valorcelda].dpxlowstop) >= parseFloat(aaapbtelimpio)) {
                tabla_dpx[valorcelda][losdatosaupatar[1]] = aaapbtelimpio;
                tabla_dpx[valorcelda].isfullband = 'show';
            } else {
                alert('LOW::out of range');
                tabla_dpx[valorcelda][losdatosaupatar[1]] = '';
            }
        }


        ///	tabla_dpx[valorcelda][losdatosaupatar[1]]=aaapbtelimpio;	

    }
    //	console.log(aaaobte);
    //	console.log(valorcelda);
    //	console.log(losdatosaupatar[1]);

    list_tabla_dpx_udul2dagen();

}

function duplicamereg(idposaduplicar) {
    console.log(tabla_gain_dlul[idposaduplicar].Band.substr(0, 3));
    if (tabla_gain_dlul[idposaduplicar].Band.substr(0, 3) == "UHF") {

        vindexarray = vindexarray + 1;
        tabla_dpx.push({
            Band: "UHF FULL",
            dpxlowstart: parseFloat(450),
            dpxlowstop: parseFloat(512),
            dpxhighstart: parseFloat(450),
            dpxhighstop: parseFloat(512),
            dpxlowstartcustom: parseFloat(0),
            dpxlowstopcustom: parseFloat(0),
            dpxhighstartcustom: parseFloat(0),
            dpxhighstopcustom: parseFloat(0),
            isfullband: false,
            qband: 1,
            idarray: vindexarray
        });
    } else {

        vindexarray = vindexarray + 1;
        tabla_dpx.push({
            Band: tabla_gain_dlul[idposaduplicar].Band,
            dpxlowstart: parseFloat(tabla_gain_dlul[idposaduplicar].dpxlowstart),
            dpxlowstop: parseFloat(tabla_gain_dlul[idposaduplicar].dpxlowstop),
            dpxhighstart: parseFloat(tabla_gain_dlul[idposaduplicar].dpxhighstart),
            dpxhighstop: parseFloat(tabla_gain_dlul[idposaduplicar].dpxhighstop),
            dpxlowstartcustom: parseFloat(0),
            dpxlowstopcustom: parseFloat(0),
            dpxhighstartcustom: parseFloat(0),
            dpxhighstopcustom: parseFloat(0),
            isfullband: false,
            qband: 1,
            idarray: vindexarray
        });
    }


    list_tabla_dpx_udul2dagen();
}

function modif_table_array(lacelda, valorcelda) {
    var losdatosaupatar = lacelda.split("#");

    ///document.getElementsByClassName("id0#DL_Start")[0].innerHTML;
    var aaaobte = document.getElementsByClassName(lacelda)[0].innerHTML;
    var aaapbtelimpio = aaaobte.replace('MHz', '');
    if ($.isNumeric(aaapbtelimpio)) {

        /*	console.log(	tabla_gain_dlul[valorcelda].hiddengainudstart);
        	console.log(	tabla_gain_dlul[valorcelda].hiddengainudstop);

        	console.log(	tabla_gain_dlul[valorcelda].hiddengainulstart);
        	console.log(	tabla_gain_dlul[valorcelda].hiddengainulstop);
        	*/

        if (losdatosaupatar[1] == 'DL_Start' || losdatosaupatar[1] == 'DL_Stop') {
            if (parseFloat(tabla_gain_dlul[valorcelda].hiddengainudstart) <= parseFloat(aaapbtelimpio) && parseFloat(
                    tabla_gain_dlul[valorcelda].hiddengainudstop) >= parseFloat(aaapbtelimpio)) {
                tabla_gain_dlul[valorcelda][losdatosaupatar[1]] = aaapbtelimpio;
            } else {
                alert('DL::out of range');
                tabla_gain_dlul[valorcelda][losdatosaupatar[1]] = aaapbtelimpio;
            }
        }
        if (losdatosaupatar[1] == 'UL_Start' || losdatosaupatar[1] == 'UL_Stop') {
            if (parseFloat(tabla_gain_dlul[valorcelda].hiddengainulstart) <= parseFloat(aaapbtelimpio) && parseFloat(
                    tabla_gain_dlul[valorcelda].hiddengainulstop) >= parseFloat(aaapbtelimpio)) {
                tabla_gain_dlul[valorcelda][losdatosaupatar[1]] = aaapbtelimpio;
            } else {
                alert('UL::out of range');
                tabla_gain_dlul[valorcelda][losdatosaupatar[1]] = aaapbtelimpio;
            }
        }

        ////////////////////tempporal habiamos dejado pasar a todos

        //	tabla_gain_dlul[valorcelda][losdatosaupatar[1]]=aaapbtelimpio;	

    }
    //	console.log(aaaobte);
    //	console.log(valorcelda);
    //	console.log(losdatosaupatar[1]);


    tabla_gain_udul2dagen();

}

function add_list_dpx() {
    var v_txtdpxlowstart = parseFloat($('#txtdpxlowstart').val());
    var v_txtdpxlowstop = parseFloat($('#txtdpxlowstop').val());
    var v_txtdpxhighstart = parseFloat($('#txtdpxhighstart').val());
    var v_txtdpxhighstop = parseFloat($('#txtdpxhighstop').val());

    if (v_txtdpxlowstart == "" || v_txtdpxlowstop == "" || v_txtdpxhighstart == "" || v_txtdpxhighstop == "" || isNaN(
            v_txtdpxlowstart) == true || isNaN(v_txtdpxlowstop) == true || isNaN(v_txtdpxhighstart) == true || isNaN(
            v_txtdpxhighstop) == true) {

    } else {
        // Agredo los 4 al Array.

        var v_loencontre_ch = 0;
        $.each(tabla_dpx, function(i, value) {
            if (value.dpxlowstart == v_txtdpxlowstart) {
                // Lo encontre actualizo datos.
                v_loencontre_ch = 1;
            }
            if (value.dpxlowstop == v_txtdpxlowstop) {
                // Lo encontre actualizo datos.
                v_loencontre_ch = 1;
            }
            if (value.dpxhighstart == v_txtdpxhighstart) {
                // Lo encontre actualizo datos.
                v_loencontre_ch = 1;
            }
            if (value.dpxhighstop == v_txtdpxhighstop) {
                // Lo encontre actualizo datos.
                v_loencontre_ch = 1;
            }


        });
        if (v_loencontre_ch == 0) {
            vindexarray = vindexarray + 1;
            tabla_dpx.push({
                Band: 'UNKNOW',
                dpxlowstart: parseFloat(v_txtdpxlowstart),
                dpxlowstop: parseFloat(v_txtdpxlowstop),
                dpxhighstart: parseFloat(v_txtdpxhighstart),
                dpxhighstop: parseFloat(v_txtdpxhighstop),
                dpxlowstartcustom: 0,
                dpxlowstopcustom: 0,
                dpxhighstartcustom: 0,
                dpxhighstopcustom: 0,
                isfullband: false,
                qband: 1,
                idarray: vindexarray


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

function add_channels() {
    // Si tiene DPX lo dejo cargar...
    if (tabla_dpx.length >= 1) {
        //tabla_channel_quantity
        var v_dl_channel = parseFloat($('#txtchud').val());
        var v_ul_channel = parseFloat($('#txtchul').val());

        if (v_dl_channel == "" || v_ul_channel == "" || isNaN(v_dl_channel) == true || isNaN(v_ul_channel) == true) {
            ///|| v_ul_channel ==""
            var v_loencontre_ch = 0;
        } else {

            var v_loencontre_ch = 0;


            $.each(tabla_channel_quantity, function(i, value) {
                if (value.channeldl == v_dl_channel) {
                    // Lo encontre actualizo datos.
                    v_loencontre_ch = 1;
                }
                if (value.channelul == v_ul_channel) {
                    // Lo encontre actualizo datos.
                    v_loencontre_ch = 1;
                }

            });
            if (v_loencontre_ch == 0) {
                var idbandencontrado = 99;
                /// Buscamos el id band
                for (var i = 0; i < tabla_bandas_paravaludar.length; i++) {
                    /*if (tabla_bandas_paravaludar[i].fstartul === value) {
                    	return array[i];
                    }*/
                    if (parseInt(tabla_bandas_paravaludar[i].fstartul) <= parseInt(v_ul_channel) && parseInt(
                            tabla_bandas_paravaludar[i].fstopul) >= parseInt(v_ul_channel)) {
                        if (parseInt(tabla_bandas_paravaludar[i].fstartdl) <= parseInt(v_dl_channel) && parseInt(
                                tabla_bandas_paravaludar[i].fstopdl) >= parseInt(v_dl_channel)) {
                            idbandencontrado = tabla_bandas_paravaludar[i].idband;
                        } else {
                            //	alert(" out of range DL"); 	
                        }
                    } else {
                        //	alert(" out of range UL"); 	
                    }
                    //	
                }
                //		console.log('ab idbandencontrado:'+ idbandencontrado);
                if (idbandencontrado < 99) {
                    tabla_channel_quantity.push({
                        channeldl: parseFloat(v_dl_channel),
                        channelul: parseFloat(v_ul_channel),
                        idband: idbandencontrado
                    });
                    tabla_channels();
                } else {

                    /*	tabla_channel_quantity.push({						
                    	channeldl: parseFloat(v_dl_channel),
                    	channelul: parseFloat(v_ul_channel),
                    	idband: idbandencontrado						
                    	});
                    	tabla_channels();*/

                    alert(" out of range ");

                }





                $('#txtchud').val('');
                $('#txtchul').val('');

                $("#txtchud").focus();
                $("#txtchud").focus();

            }
        }
    } else {
        alert('duplexers are required to load a channel ');
    }


}

function add_list_gain() {
    var v_txtchudstart = parseFloat($('#txtchudstart').val());
    var v_txtchudstop = parseFloat($('#txtchudstop').val());
    var v_txtchulstart = parseFloat($('#txtchulstart').val());
    var v_txtchulstop = parseFloat($('#txtchulstop').val());

    var v_gain_ul = parseFloat($('#txtulgain').val());
    var v_gain_dl = parseFloat($('#txtdlgain').val());
    var v_maxpwr_ul = parseFloat($('#txtulmaxpwr').val());
    var v_maxpwr_dl = parseFloat($('#txtdlmaxpwr').val());

    if (v_txtchudstart == "" || v_txtchudstop == "" || v_txtchulstart == "" || v_txtchulstop == "" || isNaN(
            v_txtchudstart) == true || isNaN(v_txtchudstop) == true || isNaN(v_txtchulstart) == true || isNaN(
            v_txtchulstop) == true) {

    } else {
        // Agredo los 4 al Array.

        var v_loencontre_ch = 0;
        $.each(tabla_gain_dlul, function(i, value) {
            if (value.gainudstart == v_txtchudstart) {
                // Lo encontre actualizo datos.
                v_loencontre_ch = 1;
            }
            if (value.gainudstop == v_txtchudstop) {
                // Lo encontre actualizo datos.
                v_loencontre_ch = 1;
            }
            if (value.gainulstart == v_txtchulstart) {
                // Lo encontre actualizo datos.
                v_loencontre_ch = 1;
            }
            if (value.gainulstop == v_txtchulstop) {
                // Lo encontre actualizo datos.
                v_loencontre_ch = 1;
            }

        });
        if (v_loencontre_ch == 0) {

            tabla_gain_dlul.push({
                Band: 'UNKNOW',
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

function list_po_by_customer_andpo(idnropo) {
    var temp = '';
    $.ajax({
        url: 'ajax_list_pobycutomers.php',
        data: "idcust=" + $("#txtlistcustomers").val(),
        type: 'post',
        datatype: 'JSON',
        async: false,
        success: function(data) {

            $.each(data, function(i) {
                //   console.log(data[i]);
                $.each(data[i], function(io) {
                    //console.log(data[i][io].id);
                    if (data[i][io].id == $("#txtponumber").val()) {
                        if (temp != data[i][io].text2) {
                            temp = data[i][io].text2;
                            $("#txtsonumberlu").append('<option value=' + data[i][io]
                                .text2 + '>' + data[i][io].text2 + '</option>');
                        }

                    }
                    ///$("#txtponumber").append('<option value='+data[i][io].id+'>'+data[i][io].id+'</option>');

                });
            });
            // lleno combo cliente
        }
    });

}

function list_po_by_customer(idcustomers) {
    var temp2 = '';
    $.ajax({
        url: 'ajax_list_pobycutomers.php',
        data: "idcust=" + idcustomers,
        type: 'post',
        datatype: 'JSON',
        async: false,
        success: function(data) {

            $.each(data, function(i) {
                //	   console.log(data[i]);
                $.each(data[i], function(io) {
                    //	console.log(data[i][io].id);

                    if (temp2 != data[i][io].id) {
                        temp2 = data[i][io].id;
                        $("#txtponumber").append('<option value=' + data[i][io].id + '>' +
                            data[i][io].id + '</option>');
                    }
                    //	$("#txtsonumberlu").append('<option value='+data[i][io].id+'>'+data[i][io].text2+'</option>');
                });
            });
            // lleno combo cliente
        }
    });

}


function chequearso_usado(nrosoasgin) {
    //alert(nropo);
    if ($("#txtsonumberlu").val().length != 11 && $("#txtsonumberlu").val().length > 0) {
        //   alert('Format Error in SO: XXXXXXXXSO / XXXXXXXXRM   ');
        //		$("#txtsonumberlu").val('');
    }

    if ($("#txtponumber").val() != '') {
        //
        var visrso = $("#txtsonumberlu").val().toUpperCase().search("SO");
        var visrma = $("#txtsonumberlu").val().toUpperCase().search("RM");
        if (visrso < 0) {
            if (visrso < 0) {
                //   alert('Format Error in SO: XXXXXXXXSO / XXXXXXXXRM   ');
                //   $("#txtsonumberlu").val('');
            }
        }


        var visrma = $("#txtsonumberlu").val().toUpperCase().search("RM");
        if (visrma < 0) {


            $.ajax({
                url: 'ajax_list_sobycutomers.php',
                data: "idcust=" + $("#txtlistcustomers").val() + "&nroso=" + nrosoasgin,
                type: 'post',
                datatype: 'JSON',
                async: false,
                success: function(data) {

                    $.each(data, function(i) {
                        //console.log(data[i].length);
                        if (data[i].length > 0) {
                            //  console.log(data[i][0]);
                            //  console.log(data[i][0].seedtemp);
                            if (data[i][0].seedtemp != '') {
                                $("#tkkeymarco1").val(data[i][0].seedtemp);
                            }

                            //alert('SO associated '+ data[i].items.seedtemp);
                            //  $("#txtsonumberlu").val('');
                        }

                    });
                }
            });
        } else {
            alert('RMA products must be managed from the SALE ORDERS page.');
            $("#txtsonumberlu").val('');
        }
    } else {

        var visrma = $("#txtsonumberlu").val().toUpperCase().search("RM");
        if (visrma > 0) {
            $("#txtsonumberlu").val('');
        }

        alert("PO: it can't be empty");
        $("#txtponumber").focus();
    }

}

function chequearpootrocliente(nropo) {
    //alert(nropo);
    if ($("#txtlistcustomers").val() != '') {
        $.ajax({
            url: 'ajax_list_pobycutomers.php',
            data: "idcust=" + $("#txtlistcustomers").val() + "&nropo=" + nropo,
            type: 'post',
            datatype: 'JSON',
            async: false,
            success: function(data) {

                $.each(data, function(i) {
                    //console.log(data[i].length);
                    if (data[i].length > 0) {
                        // alert('PO associated with another customer');
                        //  $("#txtponumber").val('');
                    }

                });
            }
        });
    }

}

function importar_nowl() {
    $("#importador").addClass('d-none');
    var tempchdl = '';
    var tempchul = '';
    tempchdl = $("#importchdl").val().split('\n');
    tempchul = $("#importchul").val().split('\n');
    if (tempchdl.length == tempchul.length) {
        //		console.log('las cant'+ tempchdl.length +'-las cant2:'+ tempchul.length )
        for (i = 0; i < tempchdl.length; i++) {
            ///Agrego canales.
            //			console.log('recorremos:'+  tempchdl[i] );
            if (tempchdl[i] != '') {



                var idbandencontrado = 99;
                /// Buscamos el id band
                for (var iaa = 0; iaa < tabla_bandas_paravaludar.length; iaa++) {
                    /*if (tabla_bandas_paravaludar[i].fstartul === value) {
                    	return array[i];
                    }*/
                    if (parseInt(tabla_bandas_paravaludar[iaa].fstartul) <= parseInt(tempchul[i]) && parseInt(
                            tabla_bandas_paravaludar[iaa].fstopul) >= parseInt(tempchul[i])) {
                        if (parseInt(tabla_bandas_paravaludar[iaa].fstartdl) <= parseInt(tempchdl[i]) && parseInt(
                                tabla_bandas_paravaludar[iaa].fstopdl) >= parseInt(tempchdl[i])) {
                            idbandencontrado = tabla_bandas_paravaludar[iaa].idband;
                        } else {
                            //	alert(" out of range DL"); 	
                        }
                    } else {
                        //	alert(" out of range UL"); 	
                    }
                    //console.log('abc:'+ tabla_bandas_paravaludar[i].fstartul);
                }
                //		console.log('ch impor idbandencontrado:'+ idbandencontrado);
                if (idbandencontrado < 99) {
                    if (parseFloat(tempchdl[i]) != parseFloat(tempchul[i])) {
                        tabla_channel_quantity.push({
                            channeldl: tempchdl[i],
                            channelul: tempchul[i],
                            idband: idbandencontrado
                        });
                    } else {
                        alert('Error..the channel is the same ')
                    }

                } else {
                    alert(" out of range UL");

                }



            }

        }
        $("#importchdl").val('');
        $("#importchul").val('');
        tabla_channels();


    }
}

function importar_channell() {
    $("#importador").removeClass('d-none');
}

function add_dpxdiv() {
    $("#divadddpxmm").removeClass('d-none');
}

function add_cui_SO() {
    // $('#idtxtlistcustomers').val('');
    // $('#txtcant').val('');
    ///	 idtxtlistcius txtlistcius
    var v_idtxtlistcius = $('#idtxtlistcius').val();
    var v_txtcuicant = $('#txtcant').val();

    if (v_idtxtlistcius == "") {

    } else {
        if (eval(v_txtcuicant) > 0) {
            //  $('#txtcuicant').val( $('#idtxtlistcius').val() + '#'+  $('#txtcant').val());
            //  tabla_cui_cant
            //  tabla_cui_cant.includes( $('#txtlistcius').val()  ); 
            var v_loencontre = 0;

            //				tabla_cui_cant.length
            $.each(tabla_cui_cant, function(i, value) {
                if (value.namecui == $('#txtlistcius').val()) {
                    // Lo encontre actualizo datos.
                    v_loencontre = 1;
                    tabla_cui_cant[i].cant = eval($('#txtcant').val()) + eval(tabla_cui_cant[i].cant);
                }
                //	console.log ("aaaaa" + i + '-' + value.idcui+ '--'+ value.namecui);
            });
            if (v_loencontre == 0) {
                tabla_cui_cant.push({
                    namecui: $('#txtlistcius').val(),
                    cant: $('#txtcant').val(),
                    idcui: $('#idtxtlistcius').val()
                });
            }


            var html = '<table class="table  table-striped table-sm ">';
            html += '<tr>';
            var cantcabez = tabla_cui_cant[0];
            for (var j in cantcabez) {
                jname = "";
                if (j == 'namecui') {
                    jname = "CIU";
                }
                if (j == 'cant') {
                    jname = "Quantity";
                }

                html += '<th>' + jname + '</th>';
                if (j === 'cant') {
                    html += '<th>Action</th>';
                    break;
                }
            }
            html += '</tr>';
            for (var i = 0; i < tabla_cui_cant.length; i++) {
                html += '<tr>';
                for (var j in tabla_cui_cant[i]) {
                    if ('idcui' != j) {
                        html += '<td>' + tabla_cui_cant[i][j] + '</td>';
                    }

                }
                html += '<td>  <a href="#" onclick="borrar_array(' + i +
                    ')"> <i class="fas fa-trash-alt"></i> Del</a></td>';
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



function controlattach(iddivacontrolar) {
    //console.log('call' + iddivacontrolar);
    $('.x').click(function() {
        //  console.log('CERRADO2');
        var vv_idp = $("#projectdraft").val();
        var vv_idprev = $("#projectdraftrev").val();
        var vv_se = $("#tkkeymarco1").val();

        $.ajax({
            url: 'ajax_listattachfileprojectso.php',
            data: 'idtype=' + vv_se + '&idp=' + vv_idp + '&idpr=' + vv_idprev + '&openattach=' +
                iddivacontrolar,
            type: 'post',
            datatype: 'JSON',
            success: function(data) {
                //	alert(data.resultiu);
                //   console.log(data.attachlist);
                $("#myDrop" + iddivacontrolar).empty();
                for (var i = 0; i < data.attachlist.length; i++) {
                    //     console.log(data.attachlist[i].fileattach );

                    //  myDrop1
                    $("#myDrop" + iddivacontrolar).append("<i class='fas fa-file'></i> " + data
                        .attachlist[i].fileattach + " <a href='#' onclick='delattach(" + data
                        .attachlist[i].idnroattach +
                        " )'><i class='far fa-times-circle' style='color:red'></i></a><br>");
                }

            }
        });


    });
}

function delattach(idfileatttodel) {
    /// inicio del

    //console.log(idfileatttodel);
    //console.log(nombrefile);

    Swal.fire({
        title: 'are you sure you want to delete  from the SO ?',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        cancelButtonText: 'No',
        confirmButtonText: 'Yes',
        showLoaderOnConfirm: true,
        preConfirm: (login) => {
            // alert(login);
            if (login == '') {


            } else {
                allowOutsideClick: () => !Swal.isLoading()

                var vv_idp = $("#projectdraft").val();
                var vv_idprev = $("#projectdraftrev").val();


                return fetch('delattachprojflexso.php?v2=' + idfileatttodel)
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
        // console.log(result);
        if (result.value.ok == "ok") {
            /*  Swal.fire({
                title: `${result.value.result}'`,
                imageUrl: result.value.avatar_url
              })*/
            Swal.fire({
                title: 'Deleted!',
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            }).then((result) => {
                //aca refresgg
                refrescaattach(1);
                refrescaattach(2);

            })
        } else {
            alert('Error');
        }
    })

    ///fin del
}


function refrescaattach(iddivacontrolar) {
    var vv_idp = $("#projectdraft").val();
    var vv_idprev = $("#projectdraftrev").val();
    var vv_se = $("#tkkeymarco1").val();

    $.ajax({
        url: 'ajax_listattachfileprojectso.php',
        data: 'idtype=' + vv_se + '&idp=' + vv_idp + '&idpr=' + vv_idprev + '&openattach=' + iddivacontrolar,
        type: 'post',
        datatype: 'JSON',
        success: function(data) {
            //	alert(data.resultiu);
            //       console.log(data.attachlist);
            $("#myDrop" + iddivacontrolar).empty();
            for (var i = 0; i < data.attachlist.length; i++) {
                //         console.log(data.attachlist[i].fileattach );

                //  myDrop1
                $("#myDrop" + iddivacontrolar).append("<i class='fas fa-file'></i> " + data.attachlist[i]
                    .fileattach + " <a href='#' onclick='delattach('" + data.attachlist[i].idnroattach +
                    "," + data.attachlist[i].fileattach +
                    "')'><i class='far fa-times-circle' style='color:red'></i></a><br>");
            }

        }
    });
}
</script>

<link rel="stylesheet" href="css/validator_marco.css">
<script src="smoke/js/smoke.min.js"></script>
<script src="plugins/select2/js/select2.full.min.js"></script>

<script>
// just for the demos, avoids form submit


$("#btnchangepmm").click(function() {

    var querystringq = window.location.search;
    var paramsmarco = new URLSearchParams(querystringq);
    console.log(paramsmarco.get('ciu'));
    if (paramsmarco.get('ciu') == null) {
        console.log(paramsmarco.get('ciu'));
    }
    //	console.log(querystring) // '?q=pisos+en+barcelona&ciudad=Barcelona'



    $('#esnamecus').val($('#txtlistcustomers option:selected').html()); // idso
    $('#esciu').val($('#txtlistcius option:selected').html()); // idso

    if (!$("#frmwo").hasClass("d-none")) {
        ///	$("#frmwo").addClass('d-none');
        // console.log('a ver');
        if ($('form').smkValidate()) {

            //if (tabla_channel_quantity.length >= 1 )
            //	{
            var xcantfaltantes = document.getElementsByClassName("colorfondonaranja");
            if (paramsmarco.get('ciu') == null) {
                //es lucianaaa
                $('#txtpwrsupply').prop('disabled', false);
                $('#txtdlgain').prop('disabled', false);
                $('#txtulgain').prop('disabled', false);
                $('#txtdlmaxpwr').prop('disabled', false);
                $('#txtulmaxpwr').prop('disabled', false);
                $("#btnchangepmm").addClass('d-none');

                document.getElementById("myform").submit();
            } else {
                if (xcantfaltantes.length == 0) {

                    $('#txtpwrsupply').prop('disabled', false);
                    $('#txtdlgain').prop('disabled', false);
                    $('#txtulgain').prop('disabled', false);
                    $('#txtdlmaxpwr').prop('disabled', false);
                    $('#txtulmaxpwr').prop('disabled', false);

                    $("#btnchangepmm").addClass('d-none');
                    document.getElementById("myform").submit();
                } else {
                    alert("UNIT (DL - UL) List is required. ");
                }
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
    } else {
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
        $("#btnchangepmm").addClass('d-none');
        document.getElementById("myform").submit();
    }

});
</script>


</html>
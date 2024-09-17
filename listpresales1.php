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

	
	
	////////////////////////////////////////////////
		////////////////////////////////////////////////
	////////////////////////////////////////////////
	
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
		$v27 = $_REQUEST['txtnotepo']; //
		$v28 = $_REQUEST['txtdescripmatesp']; //
		$varray_LISTCHANNEL = $_REQUEST['templistchannel']; //
		$varray_LISTDPX = $_REQUEST['templistadpx']; //		
		$varray_LISTUNIT = $_REQUEST['templistagainuldl']; //
			
	
		$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->beginTransaction();
			 try {
					 
					 // buscamos la max rev.
					$sql = $connect->prepare("select max(idrev) as maxidrev from orders  WHERE idorders = :vvidlog ");
					 $vvidpo = $vmaxid;
					$sql->bindParam(':vvidlog', $vvidpo);
					$sql->execute();
					$resultado = $sql->fetchAll();
					
					$vgeneradoidrev=0;
					$id_rev_acopiar = 0;
					foreach ($resultado as $row) 
					{
					//	echo "MAX ID REV ".$row['maxidrev']."---------------".$vvidpo;
						$vgeneradoidrev=$row['maxidrev'] +1	;
						$id_rev_acopiar=$row['maxidrev'] ;
					}
				//	echo "el nuevo id es:".$vgeneradoidrev;
					if ($id_rev_acopiar < 0)
					{
						$id_rev_acopiar = 0;
					}
					 
					 //Replico orders
					 
					 echo "1";
					$query_lista ="insert into orders SELECT idorders, idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, ".$vgeneradoidrev.", idruninfo, date_approved, quantity, typeregister, processday, processfasserver, nameapproved, active, fassrverror FROM orders where idorders = ".$vmaxid." and idrev =  ".$id_rev_acopiar;
					$connect->query($query_lista);
													
					$query_lista =" update orders set active='Y', processfasserver= false,	quantity= ".$v26.", date_approved = now() where idorders = ".$vmaxid." and idrev =  ".$vgeneradoidrev;
					$connect->query($query_lista);
				
					//Replico orders_sn
					echo "2";
						$query_lista ="insert into orders_sn SELECT idorders, idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, ".$vgeneradoidrev.", idnroserie, so_soft_external, wo_serialnumber, idruninfo, ponumber, pwrsupplytype, rcgfbwa, moden_dig, date_approved, descripcion, ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, nameapproved, notes, reqresources, typeregister, processday, processfasserver, so_original, so_associed, availablesn FROM orders_sn where idorders = ".$vmaxid." and idrev =  ".$id_rev_acopiar;
				//	echo $query_lista;
					$connect->query($query_lista);
					echo "3";					
					//y seguimos updateando
					$sentencia = $connect->prepare(" update orders_sn set pwrsupplytype = :pwrsupplytype, rcgfbwa = :rcgfbwa, moden_dig = :moden_dig, date_approved = now(),
					descripcion = :descripcion, ul_gain = :ul_gain, ul_max_pwr = :ul_max_pwr , dl_gain = :dl_gain, dl_max_pwr =:dl_max_pwr ,nameapproved=:nameapproved, 
					 notes = :notes where idorders = ".$vmaxid." and idrev =  ".$vgeneradoidrev);
															
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
						$vaccionweb="UPDATE PO";
						$vdescripaudit=" UPDATE PO :".$vgeneradoidrev;	
						$vtextaudit="update orders set 	quantity= ".$v26."** update orders_sn set pwrsupplytype = :pwrsupplytype, rcgfbwa = :rcgfbwa, moden_dig = :moden_dig, date_approved = now(),
					descripcion = :descripcion, ul_gain = :ul_gain, ul_max_pwr = :ul_max_pwr , dl_gain = :dl_gain, dl_max_pwr =:dl_max_pwr ,nameapproved=:nameapproved, 
					 notes = :notes where idorders = ".$vmaxid." and idrev =  ".$vgeneradoidrev;
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
				/////////////////////////////////////////////////////////////////////////////////////
				/////////////////////////////////////////////////////////////////////////////////////
					///Insertamos los Channel
				
					
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
							
								$sentenciach = $connect->prepare("INSERT INTO orders_sn_specs select distinct idorders, cast(:idrev as int) , cast(:idch as int)  , idnroserie, typedata, cast(:ul_ch_fr as DOUBLE PRECISION), cast(:dl_ch_fr as DOUBLE PRECISION), cast(:dpxlowstart as DOUBLE PRECISION), cast(:dpxlowstop as DOUBLE PRECISION), cast(:dpxhihgstart as DOUBLE PRECISION), cast(:dpxhihgstop as DOUBLE PRECISION), cast(:unitdlstart as DOUBLE PRECISION), cast(:unitdlstop as DOUBLE PRECISION), cast(:unitulstart as DOUBLE PRECISION), cast(:unitulstop as DOUBLE PRECISION), :notes from orders_sn_specs where idorders = :idorders and typedata = :typedata and  idrev  = ".$id_rev_acopiar."    ");								
								$sentenciach->bindParam(':idorders', $vmaxid);								
								$sentenciach->bindParam(':idrev', $vgeneradoidrev);
								$sentenciach->bindParam(':idch', $vidch);
							
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
								$vdescripaudit="DEL y NEW REG ".$vtypedatanew." presales_specs idpresales ".$vmaxid." -New Rev ".$vgeneradoidrev;		
								$vtextaudit="INSERT INTO orders_sn_specs select distinct idorders, cast(:idrev as int) , cast(:idch as int)  , idnroserie, typedata, cast(:ul_ch_fr as DOUBLE PRECISION), cast(:dl_ch_fr as DOUBLE PRECISION), cast(:dpxlowstart as DOUBLE PRECISION), cast(:dpxlowstop as DOUBLE PRECISION), cast(:dpxhihgstart as DOUBLE PRECISION), cast(:dpxhihgstop as DOUBLE PRECISION), cast(:unitdlstart as DOUBLE PRECISION), cast(:unitdlstop as DOUBLE PRECISION), cast(:unitulstart as DOUBLE PRECISION), cast(:unitulstop as DOUBLE PRECISION), :notes from orders_sn_specs where idorders = :idorders and typedata = :typedata and  idrev  = ".$id_rev_acopiar."  ";
								$vtextaudit=$vtextaudit."!!idorders:".$vmaxid;
								$vtextaudit=$vtextaudit."!!idrev:".$vgeneradoidrev;
								$vtextaudit=$vtextaudit."!!idch:".$vidch;
								$vtextaudit=$vtextaudit."!!typedata:".$vtypedata;
								$vtextaudit=$vtextaudit."!!ul_ch_fr:".$separa_ULDL[1];
								$vtextaudit=$vtextaudit."!!dl_ch_fr:".$separa_ULDL[0];
							
								
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();								
								
								/////////////////////////////////////////////////////////////////////////////////////
								/////////////////////////////////////////////////////////////////////////////////////				
								
								/////////////////////////////////////////////////////////////////////////////////////
								/////////////////////////////////////////////////////////////////////////////////////	
									
								$vidch = $vidch + 1 ;	
							}
							
						}
						
						echo "5";
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
									
									$vvidband =null;
									foreach ($arr_idband as $key => $value) {
										
											if ( $value['fstartdl'] == $separa_DPX[0]  && $value['fstopdl'] == $separa_DPX[1] && $value['fstartul'] == $separa_DPX[2] && $value['fstopul'] == $separa_DPX[3])
											{
												$vvidband = $value['idband'];
											}
											//	echo "result".$vvidband."---------".$key . ":  " . $value['idband'] . "-" .$value['fstartul']. "-comparo con:".$separa_DPX[2]."-" . $value['fstopul']. "-comparo con:".$separa_DPX[3]."-". $value['fstartdl']. "-comparo con///".$separa_DPX[0]."//" . $value['fstopdl'] ."-//comparocno".$separa_DPX[1]. "<br>";
									}

							    $sentenciach = $connect->prepare("INSERT INTO orders_sn_specs select distinct idorders, cast(:idrev as int) , cast(:idch as int)  , idnroserie, typedata, cast(:ul_ch_fr as DOUBLE PRECISION), cast(:dl_ch_fr as DOUBLE PRECISION), cast(:dpxlowstart as DOUBLE PRECISION), cast(:dpxlowstop as DOUBLE PRECISION), cast(:dpxhihgstart as DOUBLE PRECISION), cast(:dpxhihgstop as DOUBLE PRECISION), cast(:unitdlstart as DOUBLE PRECISION), cast(:unitdlstop as DOUBLE PRECISION), cast(:unitulstart as DOUBLE PRECISION), cast(:unitulstop as DOUBLE PRECISION), :notes,  cast(:idband as int)  from orders_sn_specs where idorders = :idorders and typedata = :typedata and  idrev  = ".$id_rev_acopiar."    ");								
								//$sentenciach = $connect->prepare("INSERT INTO public.orders_sn_specs(idorders, idrev, idch, idnroserie, typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, notes, idband)	VALUES (:idorders, :idrev, :idch, :idnroserie, :typedata, :ul_ch_fr, :dl_ch_fr, :dpxlowstart, :dpxlowstop, :dpxhihgstart, :dpxhihgstop, :unitdlstart, :unitdlstop, :unitulstart, :unitulstop, :notes, :idband);");
								$sentenciach->bindParam(':idorders', $vmaxid);								
								$sentenciach->bindParam(':idrev', $vgeneradoidrev);
								$sentenciach->bindParam(':idch', $vidchdpx);
							//	$sentenciach->bindParam(':idnroserie', $vconcero);
								$sentenciach->bindParam(':typedata', $vtypedata);
								$sentenciach->bindParam(':ul_ch_fr', $vconcero);
								$sentenciach->bindParam(':dl_ch_fr', $vconcero);
								$sentenciach->bindParam(':dpxlowstart', $separa_DPX[0]); //0
								$sentenciach->bindParam(':dpxlowstop', $separa_DPX[1]);
								$sentenciach->bindParam(':dpxhihgstart',$separa_DPX[2]);
								$sentenciach->bindParam(':dpxhihgstop', $separa_DPX[3]);
								$sentenciach->bindParam(':unitdlstart', $vconcero);
								$sentenciach->bindParam(':unitdlstop', $vconcero);
								$sentenciach->bindParam(':unitulstart', $vconcero);
								$sentenciach->bindParam(':unitulstop', $vconcero);
								$sentenciach->bindParam(':notes', $vnotech);
								$sentenciach->bindParam(':idband', $vvidband);
									
								$sentenciach->execute();
								
								/////////////////////////////////////////////////////////////////////////////////////
								/////////////////////////////////////////////////////////////////////////////////////								
								$vdescripaudit="DEL y NEW REG ".$vtypedatanew." presales_specs idpresales ".$vmaxid." -New Rev ".$vgeneradoidrev;			
								
								
								$vtextaudit="insert into orders_sn SELECT idorders, idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, ".$vgeneradoidrev.", idnroserie, so_soft_external, wo_serialnumber, idruninfo, ponumber, pwrsupplytype, rcgfbwa, moden_dig, date_approved, descripcion, ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, nameapproved, notes, reqresources, typeregister, processday, processfasserver, so_original, so_associed FROM orders_sn 	where idorders = ".$vmaxid."  and idrev in (select max(idrev) from orders_sn  where idorders = ".$vmaxid."   )";
								$vtextaudit=$vtextaudit."!!idorders:".$vmaxid;
								$vtextaudit=$vtextaudit."!!idrev:".$vgeneradoidrev;
								$vtextaudit=$vtextaudit."!!idch:".$vidch;
								$vtextaudit=$vtextaudit."!!typedata:".$vtypedata;
								$vtextaudit=$vtextaudit."!!dpxlowstart:".$separa_DPX[0]; //0
								$vtextaudit=$vtextaudit."!!dpxlowstop:".$separa_DPX[1];
								$vtextaudit=$vtextaudit."!!dpxhihgstart:".$separa_DPX[2];
								$vtextaudit=$vtextaudit."!!dpxhihgstop:".$separa_DPX[3];
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
						echo "6";
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
								
									$vvidband =null;
									foreach ($arr_idband as $key => $value) {
										//	echo $key . ":  " . $value['idband'] . "-" . $value['fstartul']. "-" . $value['fstopul']. "-" . $value['fstartdl']. "-" . $value['fstopdl'] . "<br>";
											if ( $value['fstartdl'] == $separa_DPX[0]  && $value['fstopdl'] == $separa_DPX[1] && $value['fstartul'] == $separa_DPX[2] && $value['fstopul'] == $separa_DPX[3])
											{
												$vvidband = $value['idband'];
											}
									}
									
									
							//	$vnotech  =  $separa_UNIT[0]."*".$_REQUEST['txtnotedpc']; //
								$vnotech  =  $_REQUEST['txtnotedpc']; //
								$sentenciach = $connect->prepare("INSERT INTO orders_sn_specs select distinct idorders, cast(:idrev as int) , cast(:idch as int)  , idnroserie, typedata, cast(:ul_ch_fr as DOUBLE PRECISION), cast(:dl_ch_fr as DOUBLE PRECISION), cast(:dpxlowstart as DOUBLE PRECISION), cast(:dpxlowstop as DOUBLE PRECISION), cast(:dpxhihgstart as DOUBLE PRECISION), cast(:dpxhihgstop as DOUBLE PRECISION), cast(:unitdlstart as DOUBLE PRECISION), cast(:unitdlstop as DOUBLE PRECISION), cast(:unitulstart as DOUBLE PRECISION), cast(:unitulstop as DOUBLE PRECISION), :notes ,cast(:idband as int)  from orders_sn_specs where idorders = :idorders and typedata = :typedata and  idrev  = ".$id_rev_acopiar."    ");								
								
								$sentenciach->bindParam(':idorders', $vmaxid);								
								$sentenciach->bindParam(':idrev', $vgeneradoidrev);
								$sentenciach->bindParam(':idch', $vidchunit);
								//$sentenciach->bindParam(':idnroserie', $vconcero);
								$sentenciach->bindParam(':typedata', $vtypedata);
								$sentenciach->bindParam(':ul_ch_fr', $vconcero);
								$sentenciach->bindParam(':dl_ch_fr', $vconcero);
								$sentenciach->bindParam(':dpxlowstart', $vconcero);
								$sentenciach->bindParam(':dpxlowstop', $vconcero);
								$sentenciach->bindParam(':dpxhihgstart',$vconcero);
								$sentenciach->bindParam(':dpxhihgstop', $vconcero);
								$sentenciach->bindParam(':unitdlstart', $separa_UNIT[0]); // 0
								$sentenciach->bindParam(':unitdlstop', $separa_UNIT[1]);
								$sentenciach->bindParam(':unitulstart',$separa_UNIT[2]);
								$sentenciach->bindParam(':unitulstop', $separa_UNIT[3]);
									$sentenciach->bindParam(':notes', $vnotech);
									$sentenciach->bindParam(':idband', $vvidband);
								$sentenciach->execute();
								
								/////////////////////////////////////////////////////////////////////////////////////
								/////////////////////////////////////////////////////////////////////////////////////								
								$vdescripaudit="DEL y NEW REG ".$vtypedatanew." presales_specs idpresales ".$vmaxid." -New Rev ".$vgeneradoidrev;		
								$vtextaudit="INSERT INTO orders_sn_specs select distinct idorders, cast(:idrev as int) , cast(:idch as int)  , idnroserie, typedata, cast(:ul_ch_fr as DOUBLE PRECISION), cast(:dl_ch_fr as DOUBLE PRECISION), cast(:dpxlowstart as DOUBLE PRECISION), cast(:dpxlowstop as DOUBLE PRECISION), cast(:dpxhihgstart as DOUBLE PRECISION), cast(:dpxhihgstop as DOUBLE PRECISION), cast(:unitdlstart as DOUBLE PRECISION), cast(:unitdlstop as DOUBLE PRECISION), cast(:unitulstart as DOUBLE PRECISION), cast(:unitulstop as DOUBLE PRECISION), :notes from orders_sn_specs where idorders = :idorders and typedata = :typedata and  idrev  = ".$id_rev_acopiar."  ";
								$vtextaudit=$vtextaudit."!!idorders:".$vmaxid;
								$vtextaudit=$vtextaudit."!!idrev:".$vgeneradoidrev;
								$vtextaudit=$vtextaudit."!!idch:".$vidch;
								$vtextaudit=$vtextaudit."!!typedata:".$vtypedata;
								$vtextaudit=$vtextaudit."!!unitdlstart:".$separa_UNIT[0];
								$vtextaudit=$vtextaudit."!!unitdlstop:".$separa_UNIT[1];
								$vtextaudit=$vtextaudit."!!unitulstart:".$separa_UNIT[2];
								$vtextaudit=$vtextaudit."!!unitulstop:".$separa_UNIT[3];
									$vtextaudit=$vtextaudit."!!idband:".$vvidband;
							
								
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();								
								
								/////////////////////////////////////////////////////////////////////////////////////
								/////////////////////////////////////////////////////////////////////////////////////	
									
								$vidchunit = $vidchunit + 1 ;	
							}
							
					   }	
						echo "7";
					//	$query_lista ="INSERT INTO presales_states(idpresales, idstate, datestate)	VALUES (".$vmaxid.", 1, now());";
					// $connect->query($query_lista);
					///Notificaciones
					$msjalertglobo="New Revision PO: ".$v3."";
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
					exit();
				}
	}
	
	
	
	////////////////////////////////////////////////
	////////////////////////////////////////////////
	
	//echo array_pop(explode('/', $_SERVER['PHP_SELF']))."-userfas".$_SESSION["a"]."-idbusiness:".$_SESSION["i"];
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
			if ( $row["idmenu_action"]==1)
			{
			//1	"Create/Edit PO"
				$permiso_create_edit_po = "Y";			
			}
			if ( $row["idmenu_action"]==2)
			{
			//2	"Config Paramaters PO"
				$permiso_param_po = "Y";
			}
			if ( $row["idmenu_action"]==3)
			{
			//3	"SO Assing"
				$permiso_assing_so = "Y";
			}
			if ( $row["idmenu_action"]==4)
			{
			//4	"SN Assing"
				$permiso_assing_sn = "Y";
			}
			

		}
	
		if ($pag_habilitada == "N")
		{
			///echo "the user: ".$_SESSION["b"]." cannot access the menu: ".array_pop(explode('/', $_SERVER['PHP_SELF'])).", contact the webfas administrator";
			header("Location: http://".$ipservidorapache."/".$folderservidor."/permissiondenied.php?b=".$_SESSION["b"]."&c=".array_pop(explode('/', $_SERVER['PHP_SELF'])));
			exit();
		}
	
	
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
  
  <link href="css/select2.css" rel="stylesheet" />
<link href="css/testcssselector.css" rel="stylesheet" />
  
 <link href="css/tabulator_bulma.css" rel="stylesheet">
 
  
    <link rel="stylesheet" href="cssfiplex.css">
	
		<style>
	body
{
  font-family: Arial, Helvetica, sans-serif;
  font-size:14px;
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
</style>


</head>

<input type="hidden" name="uso" id="uso" value="0">
<body class="hold-transition sidebar-mini sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
 
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
            <h1>List PO / SO </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">List PO / SO</li>
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

            <div class="" name="divscrolllog" id="divscrolllog" style="display">
		
			  <div class="demo-container">
  
			
			
			
				<div class="card">
				 	<p align="right">
			<a href="generarsaleorders.php" style="color:#0053a1;"><i class='fas fa-plus-circle' style='font-size:24px;color:#0053a1;'></i>Create New PO / SO</a> &nbsp;&nbsp;
				<a href="generarsaleorders.php?add=Y" style="color:#0053a1;"><i class='fas fa-calendar-plus' style='font-size:24px;'></i> Add CIU to PO / SO</a> &nbsp;&nbsp;
			</p>
				 <div class="row container">				
						 
				</div>			
    		  
			<!-- aca form -->			
					<form  action="listpresales.php" method="post" class="form-horizontal" id="myform" name="myform">	
					<input class="form-control" id="poselecm" type="hidden" name="poselecm">
					<input class="form-control" id="poselecmrev" type="hidden" name="poselecmrev">
					<input class="form-control" id="myInput" type="text" placeholder="Search..">
					<!--- demo acordion--->
					<table class="table table-condensed table-sm  table-striped  ">
                  <thead>
                    <tr>
                        <th>Date</th>
						<th>Customer</th>
						<th>SO </th>
					    <th>CIU - Quantity </th>
						
                      <th>ChkList</th>					
					  <th>P.Config</th>                           
					   <th>CreateSO</th>
						<th>SNsAssign</th>    					   
                    </tr>
                  </thead>
                  <tbody id="myTable">
					
					<?php
					/*
					select  distinct pre.idpresales,idrev, namecustomers,ponumber, products.modelciu ciu, quantity,  maxdatestate as datestate ,coalesce(prestatus.idstate,1) as idstates
													from presales as pre
													inner join products
													on products.idproduct = pre.idproduct  
													inner join customers
													on customers.idcustomers = pre.idcustomers
													inner join presales_states as  prestatus 
													on prestatus.idpresales = pre.idpresales 
													inner join 
													(
														select idpresales, max(datestate) as maxdatestate from presales_states
														group by idpresales
													) as maxstatebypo
													on maxstatebypo.idpresales  = prestatus.idpresales and 
													   maxstatebypo.maxdatestate =  prestatus.datestate	
													 inner join 
													(
														select idpresales, max(idrev) as maxiderev from presales
														group by idpresales
													) as maxidrevxpo
													on maxidrevxpo.idpresales  = pre.idpresales and 
													   maxidrevxpo.maxiderev =  pre.idrev	  
													where pre. typeregister='PO'   
													ORDER BY maxdatestate DESC  


*/
						 $sql = $connect->prepare("
select  distinct namecustomers ,  ponumber ,so_soft_external, pre.active,fassrverror, pre.processfasserver, pre.idorders,pre.idrev,  products.modelciu ciu, quantity,  pre.date_approved as datestate ,prestatus.idstate as idstates
from orders as pre
inner join products
on products.idproduct = pre.idproduct  												
inner join customers
on customers.idcustomers = pre.idcustomers
inner join orders_states as  prestatus 
on prestatus.idorders = pre.idorders 
inner join 
													(
														select idorders, max(datestate) as maxdatestate from orders_states
														group by idorders
													) as maxstatebypo
													on maxstatebypo.idorders  = prestatus.idorders and 
													   maxstatebypo.maxdatestate =  prestatus.datestate	
 inner join 
													(
														select idorders, max(idrev) as maxiderev from orders
														group by idorders
													) as maxidrevxpo
													on maxidrevxpo.idorders  = pre.idorders and 
													   maxidrevxpo.maxiderev =  pre.idrev	 													  
inner join orders_sn
on orders_sn.idorders = pre.idorders 
where (pre.typeregister = 'PO' and pre.active <>'N'   ) or (pre.typeregister = 'SO' and pre.active ='P'   ) 

order by datestate




													");
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
								$namecustomers = $row['namecustomers']; 
								$cortonamecustomers = substr($row['namecustomers'],0,10).".."; 
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
										$msjerrorfasserver = "<label class='text-danger'>".$row['fassrverror']." </label>";  
								}
									
							
								$proximo_hab = "N";
								
								if ($so_number =="")
								{
									$so_number ="SO uninsigned";
								}
								?>
								
								 <tr>                    
						<td><?php echo $date_approved." ".$date_approved_t; ?></td>
						 <td data-toggle="tooltip" data-placement="top" title="<?php echo $namecustomers; ?>"><?php echo $cortonamecustomers; ?> </td>	
                      <td class="font-weight-bold"><a href="#" title="View - Edit" onclick="show_po(<?php echo  $idpresales; ?>, 1)"><?php echo $so_number;  ?> </a>&nbsp&nbsp <a href="#" onclick="show_po(<?php echo  $idpresales; ?>, 2)" title="View - Edit"><i class='far fa-edit' style='font-size:14px'></i></a ></td>
					    <td class="font-weight-bold"><a href="#" title="View - Edit" onclick="show_po(<?php echo  $idpresales; ?>, 1)"><?php echo  $ciu; ?></a> <span class="badge badge-primary right" title="Quantity"><?php echo $quantity; ?></span></td>
					 
                      <td>
                        <div class="progress ">
						   <?php 
						   if ($msjerrorfasserver !="")
						   {
							   	echo $msjerrorfasserver;
						   }
						   else
						   {
							   
						   
							
							   if ($row['idstates']>=1 ) 
							   {
								   $proximo_hab = "S";
								   ?>
									<div class="progress-bar bg-warning" style="width: 100%"><b><i class='fas fa-check'></i><b></div>
								   <?php
							   }
							   else
							   {
								   ?>
									<div class="progress-bar bg-secondary" style="width: 0%"><span class="text-info" > Pend. <i class="fas fa-clipboard"></i></span></div>
								   <?php
							   }
							   }
						   ?>
                          
                        </div>
					</td>
                      <td class="font-weight-bold">	
						 <div class="progress ">
						 <?php  if ($row['idstates']>=2 ) 
						   {
							   ?>
							    <div class="progress-bar bg-info" style="width: 100%"><b><i class='fas fa-check'></i><b></div>
							   <?php
						   }
						   else
						   {
								if ( $proximo_hab == "S")
								{
									   $proximo_hab = "N";
									 ?>
							    <div class="progress-bar bg-secondary" style="width: 0%"><span class="text-info" > Pend. <i class="fas fa-cogs"></i></span></div>
							   <?php
								}
								else
								{
									 ?>
							    <div class="progress-bar bg-secondary" style="width: 0%"><span class="text-info" > Pending.<i class="fas fa-cogs"></i></span></div>
							   <?php
								}
							  
						   }
						   ?>
                          
                        </div>
                      </td class="font-weight-bold">
					       <td>	
						 <div class="progress ">
						 <?php  if ($row['idstates']>=3 ) 
						   {
							   ?>
							    <div class="progress-bar bg-danger" style="width: 100%"><b><i class='fas fa-check'></i><b></div>
							   <?php
						   }
						   else
						   {
							   if ( $proximo_hab == "S")
								{	
									$proximo_hab = "N";
							   ?>
							    <div class="progress-bar bg-secondary" style="width: 0%"><span class="text-info" > Pend. <i class="fas fa-barcode"></i></span></div>
							   <?php
								}
								else
								{
									 ?>
							    <div class="progress-bar bg-secondary" style="width: 0%"><span class="text-info" > Pend. <i class="fas fa-barcode"></i></span></div>
							   <?php
								}	
								
						   }
						   ?>
                          
                        </div>
                      </td>
					       <td class="font-weight-bold">	
						 <div class="progress ">
						  <?php  if ($row['idstates']==4 ) 
						   {
							   ?>
							    <div class="progress-bar bg-success" style="width: 100%"><b><i class='fas fa-check'></i><b></div>
							   <?php
						   }
						   else
						   {
							   if ( $proximo_hab == "S")
								{	
									$proximo_hab = "N";
							   ?>
							    <div class="progress-bar bg-secondary" style="width: 0%"><span class="text-info" > Pend. <i class="fas fa-clipboard"></i></span></div>
							   <?php
								}
								else
								{
								  ?>
							    <div class="progress-bar bg-secondary" style="width: 0%"><span class="text-info" > Pend. <i class="fas fa-clipboard"></i></span></div>
							   <?php	
								}
						   }	
						   ?>
                          
                        </div>
                      </td>
								<?php

								}
					?>
				
				
				
                   
                  </tbody>
                </table>
					<!----fin demo accordion -->
			
				
				 
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
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
				
				
                  <i class="fas fas fa-tag mr-1"></i>               
				  <span name="podatos" id="podatos" class="d-none "></span> 
                </h3><p name="ciusnshow" id="ciusnshow" class="text-primary ">  </p>
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                      <li class="nav-item" name="divgeneralinfo" id="divgeneralinfo">
                      <a class="nav-link active" href="#generalinfopo" data-toggle="tab">Info PO / SO</a>
                    </li>
					<li class="nav-item" name="divgeneralinfoparam" id="divgeneralinfoparam">
                      <a class="nav-link" href="#editparampo" data-toggle="tab">Edit Parameters PO / SO</a>
                    </li>				  
					
					 <li class="nav-item" name="diveq" id="diveq">
                      <a class="nav-link " href="#cuiparamealbert" data-toggle="tab">CIU Parameters Config</a>
                    </li> 
					 <li class="nav-item" name="diveq" id="diveq">
                      <a class="nav-link " href="#cuiparalu" data-toggle="tab">SO Assign </a>
                    </li> 	
					 <li class="nav-item" name="diveq" id="diveq">
                      <a class="nav-link " href="#cuiparachir" data-toggle="tab">SN Assign </a>
                    </li> 	
                  </ul>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
				<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>
                  <!-- Morris chart - Sales -->
				  <div class="chart tab-pane pre-scrollablemarco  " id="editparampo" style="position: relative; ">
					
					
					<div class="form-group row" >
					<label for="inputPassword" class="col-sm-1 col-form-label">Ciu Model:</label>
					<div class="col-sm-4">
					    <span name="txtciushow" id="txtciushow" >  </span>
						<input type="hidden"  id="txtlistcius" name="txtlistcius" value="">
						</div>
					<label for="inputPassword" class="col-sm-2 col-form-label">Quantity:</label>
					<div class="col-sm-4">
					<input type="number" class="form-control col-3" id="txtcant" name="txtcant" data-smk-type="number" min="1"  data-validate="true" required placeholder="quantity" value="1">	

					</div>
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
					 <table class="table-sm " >
						
						<tr>
							<td><label  class=" col-form-label">Unit DL (MHz): Start: </label>	<input type="number" class="form-control col-sm-8" id="txtchudstart" min=1 data-validate="false" name="txtchudstart" placeholder="000.000"></td>
							<td><label  class=" col-form-label">  &nbsp; Stop: </label>  <input type="number" class="form-control  col-sm-8" id="txtchudstop" min=1 data-validate="false" name="txtchudstop" placeholder="000.000"> </td>
						</tr>
						<tr>
							<td><label  class=" col-form-label">Unit UL (MHz):	   Start: </label> <input type="number" class="form-control  col-sm-8" min=1 id="txtchulstart" data-validate="false" name="txtchulstart" placeholder="000.000"> </td>
							<td><label  class=" col-form-label">  &nbsp; Stop: </label>  <input type="number" class="form-control  col-sm-8" min=1 id="txtchulstop" data-validate="false" name="txtchulstop" placeholder="000.000">  </td>
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
							<td><label  class=" col-form-label">DPX low pass start (MHz): </label>	<input type="number" class="form-control col-sm-8" id="txtdpxlowstart" min=1 name="txtdpxlowstart" placeholder="000.000"></td>
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
					   <label  class="col-sm-6 col-form-label">DL Channels (MHz):</label>  <input type="number" class="form-control" data-validate="false" id="txtchud" min=1 name="txtchud" placeholder="000.000">
					  <label  class="col-sm-6 col-form-label">UL Channels (MHz):	</label>    <input type="number" class="form-control" data-validate="false" id="txtchul" min=1 name="txtchul" placeholder="000.000"> 
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
						<button type="button" class="btn btn-primary btn-block" id="btnchangep" name="btnchangep" onclick="save_new_rev()" >Save </button>
					</div>
						<?php  } ?>
				  </div>	
					

				  </div>
				    <div class="chart tab-pane pre-scrollablemarco  " id="cuiparalu" style="position: relative; ">
					<!-- inicio modif luciana -->
					
					<div class="form-group row">
					<label for="inputPassword" class="col-sm-2 col-form-label">SO Number</label>
					<div class="col-sm-4	">
					  <input type="text" class="form-control" id="txtsoluumber" name="txtsoluumber" required="" placeholder="SO Number">
					  
					    <span name="lblsonumber" id="lblsonumber" class="text-danger "></span> 
					</div>
					
					<div class="col-sm-4">
					 
					</div>
				  </div>				
					
					<!-- NUEVO RENGLON FORM  -->
									  <!-- NUEVO RENGLON FORM  -->
					
					  
						 <div class="form-group row">
					  
						<div class="col-sm-4	">
						
						  
						</div>
							<?php 
							
							if ($permiso_assing_so =="Y")
							{
														?>
						<div class="col-sm-4">
							<button type="button" class="btn btn-primary btn-block" id="btnchangep_lu" onclick="saveLuciana()" name="btnchangep_lu">Assign SO</button>
						</div>
							<?php } ?>
					  </div>
					<!-- fin modificaciones luciana -->
					</div>
					<div class="chart tab-pane pre-scrollablemarco" id="cuiparachir" name="cuiparachir" style="position: relative; ">
					</div>
				     <div class="chart tab-pane pre-scrollablemarco active " id="generalinfopo" style="position: relative; ">
							<!----- INICIO LISTA PO  -->
				
								
							<!----- fin INICIO LISTA PO  -->
				   </div>
				    <div class="chart tab-pane pre-scrollablemarco  " id="cuiparamealbert" style="position: relative; ">
					<!-- inicio modif alebrt -->
					
									
						<!-- NUEVO RENGLON FORM  -->
					<div class="form-group row">
					
							<label for="inputPassword" class="col-sm-21 col-form-label"> &nbsp&nbsp Training required for PP-ASSY</label>
							<div class="col-sm-2">
							<input type="checkbox"  data-toggle="toggle" data-on="YES" data-off="NO" id="txtppassy_abert" name="txtppassy_abert" >
							</div>  
							<label for="inputPassword" class="col-sm-2 col-form-label">Training required for Calibration</label>
							<div class="col-sm-2">
							<input type="checkbox"  data-toggle="toggle" data-on="YES" data-off="NO" id="txtreqcalib_abert" name="txtreqcalib_abert" >
							</div> 
					</div>
					<div class="form-group row">		
							<label for="inputPassword" class="col-sm-2 col-form-label">Special Material required</label>
							<div class="col-sm-2">
							<input type="checkbox"  data-toggle="toggle" data-on="YES" data-off="NO" id="txtmatespecial_abert" name="txtmatespecial_abert" >
							</div> 
							<label for="inputPassword" class="col-sm-2 col-form-label">Other</label>
							<div class="col-sm-2">		
							<input type="checkbox"  data-toggle="toggle"  data-off="NO" data-on="YES" id="txtotherchange_abert" name="txtotherchange_abert" >
							</div>			
						</div>  
					<!-- NUEVO RENGLON FORM  -->
								  <!-- NUEVO RENGLON FORM  -->
					<div class="form-group row">
					<label for="inputPassword" class="col-sm-2 col-form-label">Description of Resources Required:</label>
					<div class="col-sm-6	">
					   <textarea class="form-control" id="txtdescripmatesp_abert" name="txtdescripmatesp_abert" rows="4"></textarea>
					  
					</div>
					
				  </div>
				  
					 <div class="form-group row">
				  
					<div class="col-sm-4	">
					
					  
					</div>
						<?php if ($permiso_param_po =="Y")
							{
							?>
								<div class="col-sm-4">
									<button type="button" class="btn btn-primary btn-block " id="btnchangep_abert" onclick="savealbert()"  name="btnchangep_abert">Save </button>
								</div>
							<?php } ?>
				  </div>
					<!-- fin modificaciones alebert -->
					
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

  <script src="js/jquery-1.11.1.min.js"></script>
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
  <link href="css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="js/bootstrap4-toggle.min.js"></script>
<script src="js/bootstrap-typeahead.js"></script>

<link rel="stylesheet" href="sweetalert2/msweetalert2.min.css">
					<script src="sweetalert2/msweetalert2.min.js"></script>
<script src="js/select2.min.js"></script>
</body>

<script type="text/javascript">

 var tabla_cui_cant = [];
  var tabla_channel_quantity = [];
var tabla_gain_dlul= [];
var tabla_dpx =[];

   
	$( document ).ready(function() {
		
		//Inicio mostrar hora live
			$('#msjwaitline ').hide();
		 var interval = setInterval(function() {
			 
        var momentNow = moment();
		var newYork    = momentNow.tz('America/New_York').format('ha z');
        $('#date-part').html(momentNow.format('YYYY/MM/DD') 	  );
        $('#time-part').html(momentNow.format('hh:mm:ss'));
	
		}, 100);
		//FIN mostrar hora live
		//	console.log( "ready!" );
			$('#msjwaitline ').hide();
			   $('.js-example-basic-single').select2();
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

				  if ($(window).height()>640)
			{
				var altor=  $(window).height() - 200+'px';
			}
			else
			{
				var altor=  "560px";
			}
			var coloresscrpit = ""
		    var vv_userruninfo="";
			var vv_station ="";
			
					

		///fin prueba de tabulator
		  $("#myInput").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#myTable tr").filter(function() {
			  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		  });
	
			 $("#txtsoluumber").change(function(){
					$("#lblsonumber").html(''); 
					
				 $.ajax
				({ 
					url: 'checksousado.php',
					data: "so="+ $("#txtsoluumber").val(),	
					type: 'post',				
					datatype:'JSON',                
					success: function(data)
					{
						
						if (data.result=='used')
						{
						$("#lblsonumber").html(' <b>Sale Orders Used!!!</b>');	
						}
						
					}
				});				
				
				
			});
			
			
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
     		
		

	function show_po(vidpo, idshow)
	{
		
			 tabla_cui_cant = [];
			tabla_channel_quantity = [];
			tabla_gain_dlul= [];
			tabla_dpx =[];
		   
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
				
			toastr["success"]("Wait....Search Results", "Attention :: PO List");
			var tabla_info_show_po = "";
			var v_rcgfbwa ="";
			var v_moden_dig ="";
			var cantrequired =0;
		 $.ajax
			({ 
				url: 'readpoinfo.php',
				data: "idpo="+vidpo,	
				type: 'post',				
				datatype:'JSON',                
				success: function(data)
				{
					
				///alert(data);
					console.log('abc'+data.length+'----'+data.ps[0].descripcion+'////'+ data.ps[0].idpresales);
					 $("#msjwaitline").hide();
					 
					 //show data po y rebv
					  $("#podatos").html(' SO:'+ data.ps[0].so_soft_external+' Rev:'+data.ps[0].idrev+'<br><br>');
					  $("#podatos").removeClass('d-none');
					 //  tabla_info_show_po="";
					  tabla_info_show_po=tabla_info_show_po+"<table class='table table-striped '><tbody><tr><td> <b>CIU: </b></td><td>"+data.ps[0].ciu+"</td><td> <b>Quantity: </b></td><td>"+data.ps[0].quantity+"</td></tr>";
					 
					  $("#txtcant").val(data.ps[0].quantity);
					  $('#txtcant').attr('min', data.ps[0].quantity);  
					  cantrequired = data.ps[0].quantity;
					 $("#poselecm").val(data.ps[0].idpresales);
					 $("#poselecmrev").val(data.ps[0].idrev);
					
					 $("#txtdescripso").val(data.ps[0].descripcion);
					 $("#txtnotepo").val(data.ps[0].notes);
					  tabla_info_show_po=tabla_info_show_po+"<tr><th>PO Numbre:<br></th><td colspan=3>"+data.ps[0].ponumber+"</td></tr>";	
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
					 
					// document.getElementById("btnchangep").disabled = false;	
					//    document.getElementById("btnchangep_abert").disabled = false;		
						/*
					  if (data.ps[0].so_soft_external != "")
					  {
						 //  btnchangep
							 var element =  document.getElementById('btnchangep');
								if (typeof(element) != 'undefined' && element != null)
								{
								  // Exists.
								   document.getElementById("btnchangep").disabled = true;		
								}
						// 			  
						  // Alber puedo modificar PO con SO
						   var element =  document.getElementById('btnchangep_abert');
								if (typeof(element) != 'undefined' && element != null)
								{
								  // Exists.
								   document.getElementById("btnchangep_abert").disabled = true;		
								}
						  //document.getElementById("btnchangep_abert").disabled = true;
						  
					  }else
					  {
						  	 var element =  document.getElementById('btnchangep');
								if (typeof(element) != 'undefined' && element != null)
								{
								  // Exists.
								   document.getElementById("btnchangep").disabled = false;		
								}
						// 			  
						  // Alber puedo modificar PO con SO
						   var element =  document.getElementById('btnchangep_abert');
								if (typeof(element) != 'undefined' && element != null)
								{
								  // Exists.
								   document.getElementById("btnchangep_abert").disabled = false;		
								}
					  } */
					  
					   document.getElementById("txtlistcius").value = data.ps[0].idproduct;
					    	$('#txtciushow').html(data.ps[0].ciu);
					   
					   
					  
					  
						$('#generalinfopo').html(tabla_info_show_po);
						
						/// vamos a mostrarr los CUI con STOCK
						tabla_info_stock="";
							tabla_info_stock=tabla_info_stock+"<table class='table table-striped '><tbody><tr><td colspan=4> <b> Stock CIU: </b></td></tr>";
							console.log(data.ps[0].ciu.substr(0,4));
							if (data.ps[0].ciu.substr(0,4) =="DH7S")
							{
							tabla_info_stock=tabla_info_stock+"<tr><td colspan='2'><input type='hidden' name='quiengenerarlossn' id='quiengenerarlossn' value=''>  </td><td colspan='2'> <button type='button' class='btn btn-block btn-outline-success' onclick='seleciongenerasn(2)' name='btnsn2' id='btnsn2'>Assign SN User</button> </td></tr>";	
							}
							else
							{
								tabla_info_stock=tabla_info_stock+"<tr><td colspan='2'><input type='hidden' name='quiengenerarlossn' id='quiengenerarlossn' value=''><button type='button' class='btn btn-block btn-outline-primary' onclick='seleciongenerasn(1)' name='btnsn1' id='btnsn1'>Assign SN FasServer</button>  </td><td colspan='2'> <button type='button' class='btn btn-block btn-outline-success' onclick='seleciongenerasn(2)' name='btnsn2' id='btnsn2'>Assign SN User</button> </td></tr>";
							}
						
							

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
											tabla_info_stock=tabla_info_stock+"<input  type='checkbox' class='combomarco' onclick='sumarme_asign_sn()' value='"+itemstock.wo_serialnumber+"|"+itemstock.so_soft_external+"' id='chkstock"+itemstock.wo_serialnumber+"' name='chkstock"+itemstock.wo_serialnumber+"' "+ischequed+" > "+itemstock.wo_serialnumber+"<br>";											
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
											tabla_info_stock=tabla_info_stock+"<input  type='checkbox' class='combomarco' onclick='sumarme_asign_sn()' value='"+itemstock.wo_serialnumber+"|"+itemstock.so_soft_external+"' id='chkstock"+itemstock.wo_serialnumber+"' name='chkstock"+itemstock.wo_serialnumber+"' "+ischequed+" > "+itemstock.wo_serialnumber+"<br>";											
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
						  
							$('#cuiparachir').html(tabla_info_stock);
							//marcoaca deshabilito los checkbox
							$("input:checkbox").attr('disabled', true);
							$("input:checkbox").attr('disabled', true);
					//	console.log("Final nuevo"+tabla_info_stock);
						//$('#lblvuser').text(datax.vuser.replace("#"," "));
						//$('#lblvdevice').text(datax.vdecice.replace("#"," "));						
						
					
					///TEMPORAL hasta q veamos si tengo q elegir YO el SN O FAS Server$("#btnsn2").html("Assign SN User <i class='fas fa-check'></i>");
				console.log('temporal');
				$("#btnsn1").html("Assign SN FasServer ");
				$("#btnsn2").html("Assign SN User <i class='fas fa-check'></i>");
				$("#quiengenerarlossn").val(2);
				$("input:checkbox").attr('disabled', false);
				}
				
				
			});
			
	}
  
   function sumarme_asign_sn()
   {
	  // cantselect

			$("#vhcantselect").val(0);
			$("#cantselect").html(' 0' );
		
		 $('input[type=checkbox]').each(function(){
			var cb = $(this);
			
			if( typeof cb.attr('name') === 'undefined' ||cb.attr('name') === null ){
			}
			else
			{
					if (cb.attr('name').length > 8)
					{
					if ('chkstock' == cb.attr('name').substring(0,8) )
					{
						//if (  cb.attr('checked') == true);
						//{
							  if($("#"+cb.attr('name')).is(':checked')) {  
									console.log ('-aaa' +cb.attr('name') +'----*:'+ cb.attr('checked'));	
								$("#vhcantselect").val(  parseInt($("#vhcantselect").val()) + parseInt(1));
								//$("#cantselect").html(' '+     $(elemento).val() );
								$("#cantselect").html(' '+  parseInt($("#vhcantselect").val()) );
							} else {  
							//	alert("No está activado");  
							}  
							
						
					}
					}
			}

						
		});
	
	
		
   }
   
   
  
    function savechristian()
   {
	   	  
	   var tipodegeneracion = 		$("#quiengenerarlossn").val() ;
	   var va1=  $("#vhcantrequerida").val() ;
	   var va2= $("#vhcantselect").val();
	   console.log( va1 +'aaaaaa'+ va2 );
	   var los_sn_seleccionados="";
	   if (tipodegeneracion=='')
	   {
		   alert('select who generate the serial number');
	   }
		else
		{			
			if (tipodegeneracion ==1)
			{
				savechristian_fasserver();
			}
			if (tipodegeneracion ==2)
			{						
			 //  if ( va1>=va2)
			 //  {
					/////////////////////////////////////////////////////
							var vvnroso  = document.getElementById("txtsoluumber").value; 
							var vidpo = document.getElementById("poselecm").value; 			
							$('input[type=checkbox]').each(function(){
							var cb = $(this);					
								if( typeof cb.attr('name') === 'undefined' ||cb.attr('name') === null ){
								}
								else
								{
										if (cb.attr('name').length > 8)
										{
										if ('chkstock' == cb.attr('name').substring(0,8) )
										{
											  if($("#"+cb.attr('name')).is(':checked')) {  
											  
											  los_sn_seleccionados=los_sn_seleccionados+$("#"+cb.attr('name')).val()+'#';
														
												} else {  
												//	alert("No está activado");  
												}  															
										}
										}
								}						
							});
				
								$.ajax
									({ 
										url: 'ajax_update_po_so_sn.php',
										data: "idpo="+vidpo+'&so='+vvnroso+'&lossn='+los_sn_seleccionados,	
										type: 'post',				
										datatype:'JSON',                
										success: function(data)
										{
											// 
												if(data.result=="ok")
												{
																							
										Swal.fire({
									  title: 'Saved!',							  
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
												}											
										
											///alert(data.result);
										}
									});								
								console.log(los_sn_seleccionados);		
									
					/////////////////////////////////////////////////////			
			  // }
			 //  else
			 //  {
				//   alert('you must select the same amount');
			  // }
			}
	   }
   } 
   
   function savechristian_fasserver()
   {
	   	   
	  
			/////////////////////////////////////////////////////
					var vvnroso  = document.getElementById("txtsoluumber").value; 
						var vidpo = document.getElementById("poselecm").value; 
						
							$.ajax
							({ 
								url: 'ajax_update_po_so_sn.php',
								data: "idpo="+vidpo+'&so='+vvnroso,	
								type: 'post',				
								datatype:'JSON',                
								success: function(data)
								{
									// 
												
										if(data.result=="ok")
										{
											alert('Save OK');									
											window.location = 'listpresales.php';			
										}	
									///alert(data.result);
								}
							});	
			/////////////////////////////////////////////////////			
	  
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
		
		function saveLuciana()
		{
			if (document.getElementById("poselecm").value!="" ) 
			{
					if (document.getElementById("txtsoluumber").value!="" ) 
					{
						var vvnroso  = document.getElementById("txtsoluumber").value; 
						var vidpo = document.getElementById("poselecm").value; 
						
							$.ajax
							({ 
								url: 'ajax_update_po_so.php',
								data: "idpo="+vidpo+'&so='+vvnroso,	
								type: 'post',				
								datatype:'JSON',                
								success: function(data)
								{
									// 
												
																			
								Swal.fire({
							  title: 'Saved!',							  
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
									window.location = 'listpresales.php';
									///alert(data.result);
								}
							});	
						
					}
					else
					{
						alert('SO is Required ');
					}
			}
		}
		
		function savealbert()
		{
			if (document.getElementById("poselecm").value!="" ) 
			{
				//vamos a enviar los datos y estados.
				var txtppassy_abert  = document.getElementById("txtppassy_abert").checked; 
				var vidpo = document.getElementById("poselecm").value; 
				var txtreqcalib_abert  = document.getElementById("txtreqcalib_abert").checked; 
				var txtmatespecial_abert  = document.getElementById("txtmatespecial_abert").checked; 
				var txtotherchange_abert  = document.getElementById("txtotherchange_abert").checked; 
				var txtdescripmatesp_abert = document.getElementById("txtdescripmatesp_abert").value; 
				if (txtmatespecial_abert=="on")
				{
					txtmatespecial_abert = true;
				}
				if (txtotherchange_abert=="on")
				{
					txtotherchange_abert = true;
				}
				
				
				
			
			
			
							$.ajax
							({ 
								url: 'ajax_update_po.php',
								data: "idpo="+vidpo+'&eqcalib='+txtreqcalib_abert+'&ppassy='+txtppassy_abert+'&matespecial='+txtmatespecial_abert+'&otherchange='+txtotherchange_abert+'&txtdescrip='+txtdescripmatesp_abert,	
								type: 'post',				
								datatype:'JSON',                
								success: function(data)
								{
								


	if(data.result=="ok")
										{
											
										
								// 
																		
								Swal.fire({
							  title: 'Saved!',							  
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
		
									}	


									
								//	window.location = 'listpresales.php';
									///alert(data.result);
								}
							});	
				
			}
			//poselecm
		}
		
		function seleciongenerasn(idbtn)
		{
			if (idbtn ==1)
			{
				$("#btnsn1").html("Assign SN FasServer <i class='fas fa-check'></i>");
				$("#btnsn2").html("Assign SN User");
				$("#quiengenerarlossn").val(1);
				$("input:checkbox").attr('disabled', true);
				
			}
			else
			{
				$("#btnsn2").html("Assign SN User <i class='fas fa-check'></i>");
				$("#btnsn1").html("Assign SN FasServer ");
				$("#quiengenerarlossn").val(2);
				$("input:checkbox").attr('disabled', false);
			}
			
			
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
							//if (tabla_channel_quantity.length >= 1 )
							//{
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
						//	}		
							//else
							//{
								//alert( "Channel List is required. ");	
							//}
						}
						else
						{
							alert( "Power Supply Type / Gain  / Max Pwr is required. ");	
						}
					
					
			}
			
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
							  
							
												  
						  
							
							
							eTable += "<a data-toggle='collapse' data-parent='#accordion' onclick="+"show_CIU_SN2020("+idsaleorders+",'"+data[i].ciu+"','"+idsaleorders+data[i].ciu_sincara+"','') href='#collapse"+idsaleorders+data[i].ciu_sincara+"' aria-expanded='true'><img src='img/imgciu.jpg' width='40px' > "+data[i].ciu+"&nbsp;<span data-toggle='tooltip' class='badge "+ lbl_color +" mb-2 labelsom'> &nbsp;[ &nbsp;"+data[i].cant_sn+" SN &nbsp;] &nbsp; </span></a>&nbsp;<a href='#' >	</a> <br><div id='collapse"+idsaleorders+data[i].ciu_sincara+"' name id='collapse"+idsaleorders+data[i].ciu_sincara+"' class='panel-collapse in collapse'> ... </div>";
							
																			
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
						//<span data-toggle='tooltip' title='3 Calibration' class='badge bg-danger'>Final Chk</span></span> <div id='collapse"+idsaleorders+vciu+data[i].sn+"' name id='collapse"+idsaleorders+vciu+data[i].sn+"' class='panel-collapse in collapse'> ... </div>
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
						
						eTable +='<a href="#" onclick="Call_create_RMA2020('+String.fromCharCode(39)+vciu+String.fromCharCode(39)+','+String.fromCharCode(39)+data[i].sn+String.fromCharCode(39)+')" title="Create RMA?"> <i class="nav-icon fas fa-box-open"></i></a> ';	
						if (data[i].sn_modulo !="")
						{
							det_modules+= '<i  class="fas fa-sliders-h"></i> Digital Module '+data[i].sn_modulo+' '+detband+' <a href="#" onclick="mostrar_digmod('+"'"+data[i].sn_modulo.trim()+"','"+data[i].sn+"'"+')"> <i class="fas fa-eye"></i></a><br>';
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
								det_modules+= '<i class="fas fa-tools"></i> Calibration '+data[i].sn_modulocalif+'  '+detband+' <a href="#"  onclick="mostrar_digmodcalib('+"'"+data[i].sn_modulo.trim()+"','"+data[i].sn+"'"+')"> &nbsp;<i class="fas fa-eye"></i>&nbsp;</a><br>';
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
							eTable +="<span data-toggle='tooltip'  class='float-right'> &nbsp; "
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
		
</script>

</html>


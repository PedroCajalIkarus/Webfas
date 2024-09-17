<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
///echo "aaaaaaaa:".$_SESSION["a"];
 include("db_conect.php"); 
 
 	session_start();
	 if(isset($_SESSION["timeout"])){
        // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
	//	echo "***********hola".time() - $_SESSION["timeout"];
        $sessionTTL = time() - $_SESSION["timeout"];
        if($sessionTTL > $inactividad){
			session_unset();
            session_destroy();	
            header("Location: http://".$ipservidorapache."/index.php?t=timeoutinactivityhome");
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
            header("Location: http://".$ipservidorapache."/index.php?t=notcookietimeouthome");
        
	}
	
	$status = $connect->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	
	if ($status !="Connection OK; waiting to send.")
	{
	
		header("Location: http://".$ipservidorapache."/".$folderservidor."/errorconect.php");
		exit();
		
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
//		echo "a...".$vmaxid."..b..".$v6;


		$sentencia = $connect->prepare("delete from orders_sn_specs where idorders = :bidorders ");															
		$sentencia->bindParam(':bidorders', $vmaxid);
		$sentencia->execute();


		
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
		$txthavemodulerabbit = $_REQUEST['txthavemodulerabbit'];
			
		$tienerabbitcargado= 'N';
		//Buscamos si ya tiene txthavemodulerabbit RABBIT..
		$sqlmm = $connect->prepare("select distinct idorders	from orders_attributes where idorders = ".$vmaxid." and idattribute_orders = 1 ");
		$sqlmm->execute();
		$resultadoma = $sqlmm->fetchAll();
		 foreach ($resultadoma as $roddw) {
			$tienerabbitcargado= 'Y';
			
		 }
	
		$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->beginTransaction();
			 try {
					 
				$sqlquery9999 = "update orders set active = 'Y' where idorders = ".$vmaxid;
				$connect->query($sqlquery9999);
					///Insertamos los Channel
				
					 $vgeneradoidrev=0;
					 $porciones = explode("#", $varray_LISTCHANNEL);
					 $vidch=1;
					 $vtypedata="CHANNEL";
					   foreach($porciones as $elcanaluldl) {
						//	echo "el canal:".$elcanaluldl;
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
								$vdescripaudit="Complete CHANNEL - IdOrder: ".$vmaxid." - Rev ".$vconcero;		
								$vtextaudit="array recived:".$varray_LISTCHANNEL;
								$vtextaudit=$vtextaudit."!!idorders:".$vmaxid;
								$vtextaudit=$vtextaudit."!!idrev:".$vgeneradoidrev;
								$vtextaudit=$vtextaudit."!!idch:".$vidch;
								$vtextaudit=$vtextaudit."!!typedata:".$vtypedata;
								$vtextaudit=$vtextaudit."!!ul_ch_fr:".$separa_ULDL[1];
								$vtextaudit=$vtextaudit."!!dl_ch_fr:".$separa_ULDL[0];
								$vtextaudit=$vtextaudit."!!idband:".$separa_ULDL[2];
					//			echo $vtextaudit;
								$vuserfas = $_SESSION["b"];
								$typeregister="SO";
								$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
								$vaccionweb="COMPLETE SO";

								$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();
								/////////////////////////////////////////////////////////////////////////////////////
								/////////////////////////////////////////////////////////////////////////////////////				
								
							
									
								$vidch = $vidch + 1 ;	
							}
							
						}
						
				//		echo "5";
					 //$varray_LISTDPX
					 $porciones = explode("#", $varray_LISTDPX);
					 $vidchdpx=1;
					 $vtypedata="DPX";
					 foreach($porciones as $elcanaluldl) {
				//		echo "el canal:".$elcanaluldl;
						$separa_DPX  = explode("|", $elcanaluldl);
				//		echo "low".$separa_DPX[0]."--".$separa_DPX[1]."<br>";
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

							/////////////////////////////////////////////////////////////////////////////////////
							/////////////////////////////////////////////////////////////////////////////////////	
							$vdescripaudit="Complete DPX  - IdOrder: ".$vmaxid." - Rev ".$vconcero;		
								$vtextaudit="array recived:".$varray_LISTDPX;
								$vtextaudit=$vtextaudit."!!idorders:".$vmaxid;
								$vtextaudit=$vtextaudit."!!idrev:".$vgeneradoidrev;
								$vtextaudit=$vtextaudit."!!idch:".$vidch;
						 
							//	echo $vtextaudit;
								$vuserfas = $_SESSION["b"];
								$typeregister="SO";
								$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
								$vaccionweb="COMPLETE SO";

								$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
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
					 
				
					 $vidchunit=1;
					 $vtypedata="UNIT";
				//	 echo "UNIT";

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
 
						 
					 WHERE orders_sn_specs.idband NOT IN(8,1,6,7) and
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
						 SELECT orders_sn_specs.idorders ,orders_sn_specs.idrev, 8, MIN(dpxlowstart), MAX(dpxlowstop), MIN(dpxhihgstart), MAX(dpxhihgstop) ,max(objectband.dlgain),max(objectband.ulgain), max(objectband.dlmaxpwr), max(objectband.ulmaxpwr),
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
					
						 group by orders_sn_specs.idorders ,orders_sn_specs.idrev
					 
					 ) as tt1
						 order by bandorder
					 ) as tt");
					 $sentenciach->bindParam(':idorders', $vmaxid);								
					 $sentenciach->bindParam(':idrev', $vconcero);
					 $sentenciach->execute();
				
					if ($txthavemodulerabbit =="")
					{

					}
					else
					{
						if ($tienerabbitcargado== 'Y')
						{
							$query_lista ="update orders_attributes set  v_boolean = ".$txthavemodulerabbit." where  idorders =".$vmaxid." and idattribute_orders =  1 ";
							$connect->query($query_lista);
						}
						else
						{
							$query_lista ="INSERT INTO public.orders_attributes(idorders, idattribute_orders, datemodif, v_boolean, v_integer, v_double, v_string, v_date) VALUES (".$vmaxid.", 1,now(),".$txthavemodulerabbit.", NULL, NULL, NULL, NULL);";
							$connect->query($query_lista);
						}
						
						$sqlquery9999 = "update orders set active = 'Y' where idorders = ".$vmaxid;
						$connect->query($sqlquery9999);

						$query_lista ="INSERT INTO orders_states(idorders, idstate, datestate)	VALUES (".$vmaxid.", 2, (now() - interval '1 minute') );";
						$connect->query($query_lista);	
					}
					
					 
					 
					$query_lista="update  orders_sn_specs set idband = 8 where  idorders = ".$vmaxid." and typedata <> 'UNIT' and idband in(1,7,6)";
					$connect->query($query_lista);	
					 
				
					
					$return_result_insert="ok";

				    $connect->commit();


					$vuserfas = $_SESSION["b"];
					$typeregister="PO";
					$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
					$vaccionweb="Update SO";
					$vdescripaudit="Update SO- idorders:".$$vmaxid."-SetModuleRabbit - have?:".$tienerabbitcargado."-seteo:".$txthavemodulerabbit;
					$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
					$sentenciaudit->bindParam(':userfas', $vuserfas);								
					$sentenciaudit->bindParam(':menuweb', $vmenufas);
					$sentenciaudit->bindParam(':actionweb', $vaccionweb);
					$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
					$sentenciaudit->bindParam(':textaudit', $vtextaudit);
					$sentenciaudit->execute();
	////////////////////////////////////////////////

			 

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

.colorfondonaranja
{
	border-style: solid;
  border-color:rgba(0, 83, 161, 0.8);
  background-color:rgba(250, 5, 5, 0.4);
  font-weight: bold;

}

.colorfondosolomnaranja
{
	border-style: solid;
  border-color:rgba(0, 83, 161, 0.8);
  background-color:rgba(250, 5, 5, 0.4);
  font-weight: bold;

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
	  <input type='hidden' value='<?php echo $_SESSION["g"]; ?>' name='qeneslogin' id='qeneslogin'> 
        <!-- Timelime example  -->
        <div class="row">
          <section class="col-lg-6 connectedSortable ui-sortable">

            <div class="" name="divscrolllog" id="divscrolllog" style="display">
		
			  <div class="demo-container">
  
			
			
			
				<div class="card">
					 
				 	<p align="right">

					 <span align="left">
					<a href="#" onclick="createtk()" style="color:#0053a1;">&nbsp;<i class='fa fa-info-circle' style='font-size:22px;color:#0053a1;'></i>&nbsp;<b>Missing SO?</b></a>
					</span> &nbsp;&nbsp;||&nbsp;&nbsp;
			     <a href="generarsaleorders.php" style="color:#0053a1;"><i class='fas fa-plus-circle' style='font-size:24px;color:#0053a1;'></i>Create New PO / SO</a> &nbsp;&nbsp;||&nbsp;&nbsp;
				<a href="generarsaleorders.php?add=Y" style="color:#0053a1;"><i class='fas fa-calendar-plus' style='font-size:24px;'></i> Add CIU to PO / SO</a> &nbsp;&nbsp;||&nbsp;&nbsp;
				</p>
				 <div class="row container">				
						 
				</div>			
    		  
			<!-- aca form -->			
					<form  action="listpresales.php" method="post" class="form-horizontal" id="myform" name="myform">	

					<?php
					//////////////////// QUE LISTAMOSS?? ultimo año o todo.
					$queryquefiltramos="";
					$quefiltramos= $_REQUEST['qf'];
					if ($quefiltramos =="")
					{
				//		$queryquefiltramos=" and pre.date_approved > '".date(Y)."-01-01 00:00:00' ";
					///	$queryquefiltramos=" and orders_sn.processday > '2021-01-01 00:00:00' ";
					//	echo $queryquefiltramos;
					}

					//// PERMITIR BORRAR ARCHIVOS ADJUNTOS
					$puedeborrar = "N";
					if 	($_SESSION["g"] == "develop" || 	$_SESSION["j"]  == "Administration"  ) 
					{ 
						$puedeborrar = "Y";
					}
					?>
					<input value="<?php echo $puedeborrar;?>" id="puedeborrar" type="hidden" name="puedeborrar">
					<?php
					//// *********************************
					?>
					<input class="form-control" id="poselecm" type="hidden" name="poselecm">
					<input class="form-control" id="poselecmrev" type="hidden" name="poselecmrev">

					<div class="container-fluid "> 
						<div class="row mb-3 "> 
							<div class="col-sm-10">
							<input class="form-control col-md-12 form-control-sm" id="myInput" type="text" placeholder="Search..">
							</div>
							<label for="staticEmail" class="col-sm-2 col-form-label">
							<a href="#" onclick="search_infomm()">	
							<i class='fas 	fa fa-search' style='font-size:24px;' alt='click here to start the search' title='click here to start the search'></i> 
							</a>
							</label>
						
						</div>
					</div>	

				 
					<div id="ds" name="ds" class="container-fluid">

						<!--- demo acordion--->
						<div id="latabla" name="latabla">
							<table class="table table-condensed table-sm  table-striped  ">
									<thead>
										<tr>
											<th>Date</th>
											<th>Customer</th>
											<th>SO </th>
											<th>CIU  </th>
											<th>Quantity </th>
										<!-- <th >ChkList</th>					
										<th >P.Config</th>                       
										<th>SOsAssign</th>  -->  
											<th>SNsAssign</th>  
											<th>Procesed</th>    					   
										</tr>
									</thead>
									<tbody id="myTable">
										
									<?php
					$filtrer_date_marco ="";
				
					
					$filtrer_date_marco ="  (((prestatus.datestate > now() -' 30 day'::INTERVAL) ) or  pre.active ='D') and   ";
					//$filtrer_date_marco ="  ((prestatus.datestate > now() -' 30 day'::INTERVAL) or orders_sn.processday is null) and";
		
				
				 
		 
						 $sql = $connect->prepare("
select  distinct iduniquebranchsonprod, products.idproduct ,  pre.idcustomers, namecustomers ,  orders_sn.ponumber ,orders_sn.so_soft_external, pre.active,fassrverror, pre.processfasserver, pre.idorders,pre.idrev,  products.modelciu ciu, quantity,  pre.date_approved as datestate , max(prestatus.idstate) as idstates
, count(distinct orders_sn_asignados.wo_serialnumber) as cantsnasing ,  array_agg(coalesce(orders_sn_asignados.wo_serialnumber,'')) as groupxsn, min(COALESCE(maxstatebypoparadiego.idorders,0)) as diego
, orders_attributes.v_boolean::integer as isupgrade,
min(products_attributes.idattribute) as idattribute , 
COALESCE(min(products_attributes.idattribute),0) as haveupgrade
  ,min(orders_attributesrabbit.v_boolean::integer) as 	haverabbit  , products.active as activeprod ,  atrib30.v_string as issoblock,
  products_attributes_islegacy.idattribute as  idattribute_islegacy
from orders as pre
inner join fnt_select_allproducts_maxrev_bysap() as products
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
left join 
													(
														select distinct idorders  from orders_states
														where idstate = 2
														
													) as maxstatebypoparadiego
													on maxstatebypoparadiego.idorders  = prestatus.idorders 
 inner join 
													(
														select idorders, max(idrev) as maxiderev from orders
														group by idorders
													) as maxidrevxpo
													on maxidrevxpo.idorders  = pre.idorders and 
													   maxidrevxpo.maxiderev =  pre.idrev	 
													   

inner join orders_sn
on orders_sn.idorders = pre.idorders 
left join orders_sn as orders_sn_asignados
on orders_sn_asignados.idorders = pre.idorders and 
  orders_sn_asignados.idrev =  pre.idrev and 
  orders_sn_asignados.idnroserie >0 and
  orders_sn_asignados.wo_serialnumber <> ''
 left join orders_attributes as orders_attributesrabbit
 on orders_attributesrabbit.idorders  =  orders_sn.idorders 
 and  orders_attributesrabbit.idattribute_orders = 1
 left join  orders_attributes
 on orders_attributes.idorders  =  orders_sn.idorders and
 orders_attributes.idattribute_orders = 2
 
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
pre.processfasserver, pre.idorders,pre.idrev,  products.modelciu , quantity,  pre.date_approved ,  orders_attributes.v_boolean, products.active , atrib30.v_string
,products_attributes_islegacy.idattribute 
order by  datestate desc	");

 


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
						<td><?php echo $date_approved." ".$date_approved_t; ?></td>
						 <td data-toggle="tooltip" data-placement="top" title="<?php echo $namecustomers; ?>"><?php echo $cortonamecustomers; ?> </td>	
                      
					  <?php 
							$habilito_editar_so= 1;
						if ($row['active']=="D")
						{
							$habilito_editar_so= 2;
						}

					//	if ($_SESSION["g"] == "develop"  )
					//	{
						if( $row['activeprod']=="Y")
						{
							if ($quantityasignados ==0)
							{?>
					  <td class="font-weight-bold"><a href="#" title="View - Edit" onclick="show_po(<?php echo  $idpresales; ?>, <?php echo $habilito_editar_so; ?>)"><?php echo $so_number;  ?> </a>&nbsp&nbsp <a href="#" onclick="show_po(<?php echo  $idpresales; ?>, <?php echo $habilito_editar_so; ?>)" title="View - Edit"><i class='far fa-edit' style='font-size:14px'></i></a > &nbsp&nbsp <a href="#" title="Delete?" onclick="delete_po(<?php echo  $idpresales; ?>, 2)"><i class='far fa-trash-alt' style='font-size:14px'></i></a >
					  
					</td>
						<?php
							}
							else
							{
								?>
							<td class="font-weight-bold"><a href="#" title="View - Edit" onclick="show_po(<?php echo  $idpresales; ?>, <?php echo $habilito_editar_so; ?>)"><?php echo $so_number;  ?> </a>&nbsp&nbsp <a href="#" onclick="show_po(<?php echo  $idpresales; ?>, <?php echo $habilito_editar_so; ?>)" title="View - Edit"><i class='far fa-edit' style='font-size:14px'></i></a >
							
							</td>
							<?php	
							}
						}
						else
						{
							?>
							<td class="font-weight-bold"><?php echo $so_number;  ?> &nbsp&nbsp 							
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
						<td class="font-weight-bold"><a href="#" title="View - Edit" onclick="show_po(<?php echo  $idpresales; ?>, <?php echo $habilito_editar_so; ?>)"><?php echo  $ciu; ?></a>

						<?php ///echo $_SESSION["a"]; marco / diego / francesco
						if  ($_SESSION["a"]==1 ||$_SESSION["a"]==2 ||$_SESSION["a"]==17 || $_SESSION["a"]==16 || $_SESSION["a"]==8)
						{
							?>
							<a href='#' onclick="show_po(<?php echo  $idpresales; ?>, 2)"><i class="fas fa-magic"></i></a>
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
						?>&nbsp; <a href="#" title="Label printing" onclick="Call_printlabel_todos('<?php echo  $ciu; ?>',<?php echo  $idpresales; ?>)"> <i class="fas fas fa-tag mr-1"></a></i>
						<?php
					 }
					  ?>
					    	  
						&nbsp; <a href="#" title="Print SO Covers" onclick="Call_printcovers('<?php echo  $ciu; ?>',<?php echo  $quantity; ?>,'<?php echo  $so_number; ?>','<?php echo $namecustomers;?>')"> <i class="fas fa-print"></a></i>
						
					 
						<?php
						if( $row['issoblock']=="Yes")
						{
						   ?><span class='d-none'>CreditBlock</span>
<i class='fas fa-exclamation-triangle' style='font-size:12px;color:red' title='Credit Block' alt= 'Credit Block'></i>
						   <?php
   
						}
						?>
					</td>
					 <td class="font-weight-bold"><span class="badge badge-primary right" title="Quantity - Ref: IDOrders [<?php echo $idpresales; ?>]"><?php 
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
						 <div class="progress ">
						  <?php  
						$order_complete = "N";
						  if (  $quantityasignados == $quantity ) 
						   {
							$order_complete = "Y";
							   ?>
							    <div class="progress-bar bg-success" style="width: 100%"><b><i class='fas fa-check'></i><b></div>
							   <?php
						   }
						   else
						   {
							   if ( $quantityasignados > 0)
								{	
									$proximo_hab = "N";
							   ?>
							    <div class="progress-bar bg-secondary" style="width: 0%"><span class="text-info" > Processed / Pend</span></div>
							   <?php
								}
								else
								{
									if( $row['activeprod']=="S")
									{
										?>
										<div class="progress-bar bg-info" style="width: 0%"><span class="text-secondary" > No Further Action Required</div>
										<?php	
									}
									else
									{
										if ($row['haveupgrade']>0)
										{
											?>
										<div class="progress-bar bg-secondary" style="width: 0%"><span class="text-warning" > Pend. SN Assign for Upgrade  <i class="fas fa-solid fa-bell"></i></span></div>
										<?php
										}
										else
										{			
											if ($row['idattribute_islegacy'] !=30)
											//---- 30 ->	Is a Legacy unit
											{							
										?>
										<div class="progress-bar bg-secondary" style="width: 0%"><span class="text-info" > Pend. SN Assign <i class="fas fa-clipboard"></i></span></div>
										<?php
											}
											else
											{
												?>
												<div class="progress-bar bg-secondary" style="width: 0%"><span class="text-info" > SN Autogenerated <i class="fas fa-clipboard"></i></span></div>
												<?php	
											}
										}
									}
								  ?>
							    
							   <?php	
								}
						   }	
						   ?>
                          
                        </div>
                      </td>
					  <td>
					  <?php
					  $enabled_button_reprocess ="N";
					  	
					  //  echo $row['haverabbit']; //Estado BORRADOR
						if ($row['active']=="D")
						{
						////	echo "PENDIENTE DIEGO";
							if ($row['haverabbit'] =="" && $row['haverabbit']  < 0 )
							{
								echo '<span class="text-warning">Missing Rabbit Specs '.$row['haverabbit'] .' </span>';
							}
							else
							{
								echo '<span class="text-warning">Missing Parameters </span>';
							}
							//$enabled_button_reprocess ="Y";
							
							///echo '<a href="generarsaleorders.php?pre=Y&idcus='.$row['idcustomers'].'&po='.$row['ponumber'].'&so='.$row['so_soft_external'].'&qq='.$row['quantity'].'&idciu='.$row['idproduct'].'&ciu='.$row['ciu'].'&idso='.$row['idorders'].'&ncus='.$row['namecustomers'].'"><span class="text-danger"><b> <span  title="'.$msjerrorfasserver .'">Preloaded </b></a></span></span>';
						}
						else
						{  
					  	  if( $row['processfasserver']==true ||  $row['active']=="A")	
							{
								echo '  <div class="progress-bar bg-info" style="width: 100%"><b><i class="fas fa-check"></i><b></div>';
							}
							else
							{
								if ($msjerrorfasserver !='')
								{
									if ($row['active']=="D")
									{
										echo "<br>";
									}
									echo '<span class="text-danger">Pend <span  title="'.$msjerrorfasserver .'">Error </span></span>';
									$enabled_button_reprocess ="Y";
								}
							// echo "haveupgrade:".$row['haveupgrade'];
								
							}
						}

						if  ($_SESSION["a"]==1 ||$_SESSION["a"]==2 ||$_SESSION["a"]==17 )
						{
							$enabled_button_reprocess ="Y";
							if ($enabled_button_reprocess =="Y")
							{
								?>
								<a href='reprocess_so.php?dio=<?php echo $idpresales; ?>' target="_blank"><i class="fa fa-cog fa-spin  fa-fw"></i></a>
								<?php
							}
						}
?>
				
					  </td>
								<?php

								}
					?>
				
				
				
                   
                  </tbody>
                </table>
						</div>
						<!----fin demo accordion -->
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
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
				
				
                  <i class="fas fa-clipboard mr-1"></i>               
				  <span name="podatos" id="podatos" class="d-none "></span> 
                </h3><p name="ciusnshow" id="ciusnshow" class="text-primary ">  </p>
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                      <li class="nav-item" name="divgeneralinfo" id="divgeneralinfo">
                      <a class="nav-link active" href="#generalinfopo" data-toggle="tab">Info PO / SO</a>
                    </li>
					<li class="nav-item d-none" name="divgeneralinfoparam" id="divgeneralinfoparam">
					<!-- Ocultado hasta terminar esta pag y pueda editar y terminemos de definir como mostramos las unit y gain y maxpwr -->
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
					<li class="nav-item" name="diveq" id="diveq">
                      <a class="nav-link " href="#sosnupgrade" data-toggle="tab">SO / SN Assign for Upgrade </a>
                    </li> 		
                  </ul>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
				<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="80px" ></p>
                  <!-- Morris chart - Sales -->
				  <div class="chart tab-pane pre-scrollablemarco  " id="editparampo" style="position: relative; ">
					
					
					<div class="form-group row" >
					<label for="inputPassword" class="col-sm-1 col-form-label">Ciu Model:</label>
					<div class="col-sm-4">
					    <span name="txtciushow" id="txtciushow" >  </span>
						<input type="hidden"  id="txtlistcius" name="txtlistcius" value="">
							<input type="hidden"  id="kkasign" name="kkasign" value="">
						
						</div>
					<label for="inputPassword" class="col-sm-2 col-form-label">Quantity:</label>
					<div class="col-sm-4">
					<input type="number" class="form-control col-4" id="txtcant" name="txtcant" data-smk-type="number" min="1"  disabled data-validate="true" required placeholder="quantity" value="1">	

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
					<div class="form-group row">
						<label for="inputPassword" class="col-sm-3 col-form-label text-danger">Include Rabbit Module :</label> 
						<br>
						<div class="col-sm-6	">
						<select class="js-example-basic-single col-sm-4" required  id="txthavemodulerabbit" name="txthavemodulerabbit">
						<option value="">-select-</option>	
						<option value="FALSE">NO </option>
							<option value="TRUE">YES </option>
						</select>
						</div>

					</div>	
				 
					<!-- NUEVO RENGLON FORM  -->
					<!-- NUEVO RENGLON FORM  -->
					<div class="form-group d-none row">
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
				  
				 
					<!-- NUEVO RENGLON FORM  -->
					<div class="progress progress-xxs">
							 <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
							 </div>
						</div>
						<br>
					
					
					
						<!-- NUEVO RENGLON FORM  -->
					
				  
							<!-- NUEVO RENGLON FORM  -->
					<div class="form-group row">
				  
					<div class="col-sm-12">
				
									
						<div class="col-sm-12" id="listagainuldl" name="listagainuldl" >  
						
						</div>
						
					
					
				
					</div>
				  </div>  
					<!-- NUEVO RENGLON FORM  -->
					
						  <!-- NUEVO RENGLON FORM  -->
					<div class="form-group row">
		 
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

						<p align="right" >
						<button name="btnaddchannels1" id="btnaddchannels1" type="button" class="btn btn-sm btn-outline-primary btn-flat" onclick="importar_channell()">Import Channel </button>
						<div class="container d-none" id="importador" name="importador" >
  <div class="row">
    <div class="col">	DL Channels :: copy and paste the channels here
						<textarea class="form-control" id="importchdl" name="importchdl" rows="2"></textarea></div>
    <div class="col">	UL Channels :: copy and paste the channels here
						<textarea class="form-control" id="importchul" name="importchul"  rows="2"></textarea></div>
   
  </div>
  			<br><br>	<button name="btnaddchannels3" id="btnaddchannels3" type="button" class="btn btn-sm btn-outline-primary btn-flat" onclick="importar_nowl()">Import now </button>
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
					
				  <div class="form-group row">		
				  <input type="hidden" class="form-control" id="templistadpx" name="templistadpx">			
						<div class="col-sm-12">
							<div class="col-sm-12" id="listadpx" name="listadpx" > DPX (Low - High) List
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

					<br>
					<div class="progress progress-xxs">
							 <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
							 </div>
						</div>
						<br>
					
				  
					 <div class="form-group row">
				  
					<div class="col-sm-4	">
					
					  
					</div>
					
					<?php
				//	echo "H.".$permiso_create_edit_po;
					if ($permiso_create_edit_po =="Y")
							{
														?>
					<div class="col-sm-4">
						<button type="button" class="btn btn-primary btn-block " id="btnchangep" name="btnchangep" onclick="save_new_rev()" >Save </button>
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
					<div class="chart tab-pane pre-scrollablemarco" id="sosnupgrade" name="sosnupgrade" style="position: relative; ">
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
					<p name="msjwait" id="msjwait" align="center"><img src="img/waitazul.gif" width="80px" ></p>						
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
  <div id="my-pdf"></div>
  
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
					
 <script src="js/eModal.min.js" type="text/javascript" />
<script src="js/select2.min.js"></script>
<script src="https://unpkg.com/pdfobject@2.2.7/pdfobject.min.js"></script>
</body>

<script type="text/javascript">

 var tabla_cui_cant = [];
  var tabla_channel_quantity = [];
var tabla_gain_dlul= [];
var tabla_gain_dlul_onlyshow = [];
var tabla_dpx =[];

var tabla_bandas_paravaludar=[];
var tabla_dpx_solomuestra=[];

var vindexarray = 0;	
	
var cantrefresh = 0;


   
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
				

				$('#txtlistciusup').select2({
 ajax: {
    url: "ajax_list_snbyupgrade.php",
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
  placeholder: 'Search SN',
  minimumInputLength: 1 ,
  templateResult: formatRepo,
  templateSelection: formatRepoSelection
});
			
			
			
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
	

	 $("#myInput").on("keydown", function(event) {
				if(event.which == 13)
				{
					//alert("Entered!");
					toastr["success"]("Wait....Search Results", "Attention :: PO List");

					$.ajax
						({ 
							url: 'listpresales_ajaxsearch.php',
							data: "txtsearch="+$("#myInput").val(),	
							type: 'post',
							async:true,
							cache:false,
							success: function(data)
							{
							//	var datax = JSON.parse(data)
						//		console.log(data);
								$('#latabla').html(data);
								console.log('inicio crond:'+$('#myInput').val());	 	
								esperar_runinfo();
						 
							}
						});


				}
			
		});

		function search_infomm()
		{
			if ( $('#myInput').val()=='')
			{
				toastr["error"]("You must enter the text to search", "Attention :: PO List");

			}
			else
			{
				toastr["success"]("Wait....Search Results", "Attention :: PO List");

				$.ajax
						({ 
							url: 'listpresales_ajaxsearch.php',
							data: "txtsearch="+$("#myInput").val(),	
							type: 'post',
							async:true,
							cache:false,
							success: function(data)
							{
							//	var datax = JSON.parse(data)
						//		console.log(data);
								$('#latabla').html(data);
								console.log('inicio crond:'+$('#myInput').val());	 	
								esperar_runinfo();
						 
							}
						});
			}
		} 	

		function esperar_runinfo( )
	{
			 refreshIntervalIdbuscaruninfo = setInterval(function() 
			 {
				cantrefresh= cantrefresh + 1;
				 console.log( cantrefresh+ 'espero resultado del id_petition:'+$('#myInput').val());	 	 

				 if (cantrefresh < 10)
				 {

					toastr["success"]("Refresh Results", "Attention :: PO List");

							$.ajax
								({ 
									url: 'listpresales_ajaxsearch.php',
									data: "txtsearch="+$("#myInput").val(),	
									type: 'post',
									async:true,
									cache:false,
									success: function(data)
									{
									//	var datax = JSON.parse(data)
								//		console.log(data);
										$('#latabla').html(data);
									 
								
									}
								});


				 }
				 
			}, 15000);	
	}

	function show_po(vidpo, idshow)
	{

		/// SI idshow = 2 habilito para editar pametros de la orders_sn_specs.
		
			 tabla_cui_cant = [];
			tabla_channel_quantity = [];
			tabla_gain_dlul= [];
			tabla_dpx =[];
			tabla_dpx_solomuestra =[];
			
			tabla_bandas_paravaludar=[];
			$("#diveqsnassinga").removeClass('d-none');
			if (idshow ==2)
			{
				//divgeneralinfoparam
				$("#divgeneralinfoparam").removeClass('d-none');
				$("#diveqsnassinga").addClass('d-none');

			///	diveqsnassinga
			}
			
		
		   
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
			var vindexarray= 0;
		 $.ajax
			({ 
				url: 'readpoinfo.php',
				data: "idpo="+vidpo,	
				type: 'post',				
				datatype:'JSON',                
				success: function(data)
				{

					///////tabla nuevo dpx editable
					console.log(data.ps[0].ciu);
					console.log( data.ps[0].ciu.indexOf('LIC'));	
						if( data.ps[0].ciu.indexOf('LIC')>=0)
						{
							console.log('Is Lic---');
						}
						else
						{

						
										var note_unit = "";
										if (data.arr_dpxunit != null)
										{
										$.each(data.arr_dpxunit, function(i, itempsunit) {
												note_unit = itempsunit.nomband;
													
													
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
															noteditUL_gain: parseFloat(itempsunit.v_gain_ul),
															noteditDL_gain: parseFloat(itempsunit.v_gain_dl),
															noteditUL_maxpwr: parseFloat(itempsunit.v_maxpwr_ul),
															noteditDL_maxpwr: parseFloat(itempsunit.v_maxpwr_dl)
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
															isfullband: itempsunit.isfullband,
															qband: 1,
															idarray: vindexarray

														});
														
														vindexarray= vindexarray + 1 ;
													//	console.log ('ssssssssssssssssssssssssssss');

														for( var imm = 1; imm <itempsunit.cantsubband; imm++) 
															{
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
																	isfullband: itempsunit.isfullband,
																	qband:1,
																	idarray: vindexarray

																});
															}
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
														noteditUL_gain: parseFloat(itempsunit.v_gain_ul),
														noteditDL_gain: parseFloat(itempsunit.v_gain_dl),
														noteditUL_maxpwr: parseFloat(itempsunit.v_maxpwr_ul),
														noteditDL_maxpwr: parseFloat(itempsunit.v_maxpwr_dl)
													});
											
													tabla_dpx.push({	
														Band:itempsunit.nomband,												
														dpxlowstart: parseFloat(itempsunit.fstartdl),
														dpxlowstop:  parseFloat(itempsunit.fstopdl),
														dpxhighstart: parseFloat(itempsunit.fstartul),
														dpxhighstop: parseFloat(itempsunit.fstopul),
														dpxlowstartcustom: parseFloat(itempsunit.fstartdl),
														dpxlowstopcustom:  parseFloat(itempsunit.fstopdl),
														dpxhighstartcustom: parseFloat(itempsunit.fstartul),
														dpxhighstopcustom: parseFloat(itempsunit.fstopul),
														isfullband: itempsunit.isfullband,
														qband: 1,
														idarray: vindexarray
														});


														vindexarray= vindexarray + 1 ;

														for( var imm = 1; imm <itempsunit.cantsubband; imm++) 
															{
															
																tabla_dpx.push({	
																	Band:itempsunit.nomband,												
																	dpxlowstart: parseFloat(itempsunit.fstartdl),
																	dpxlowstop:  parseFloat(itempsunit.fstopdl),
																	dpxhighstart: parseFloat(itempsunit.fstartul),
																	dpxhighstop: parseFloat(itempsunit.fstopul),
																	dpxlowstartcustom:0,
																	dpxlowstopcustom:  0,
																	dpxhighstartcustom: 0,
																	dpxhighstopcustom: 0,
																	isfullband: itempsunit.isfullband,
																	qband: 1,
																	idarray: vindexarray
																	});

																

																 
															}

													}

													
											
											});
											}
											/// cierro if data.arr_dpxunit is null
										}
					////////fin tabl dpx nueva
					
				///alert(data);
				//	console.log('abc'+data.length+'----'+data.ps[0].descripcion+'////'+ data.ps[0].idpresales);
					 $("#msjwaitline").hide();
					 
					 //show data po y rebv
					  $("#podatos").html(' SO:'+ data.ps[0].so_soft_external+' Rev:'+data.ps[0].idrev+'<br><br>');
					  $("#podatos").removeClass('d-none');
					 //  tabla_info_show_po="";
					 tabla_info_show_po=tabla_info_show_po+"<table class='table table-striped '><tbody>";
					 

						 $.each(data.thebands, function(i, itemband) 
						{
						//	console.log (itemband);

							tabla_bandas_paravaludar.push({	
							idband: itemband.idband,												
							descband: itemband.description,
							fstartul:  parseFloat(itemband.fstartul),
							fstopul: parseFloat(itemband.fstopul),
							fstartdl: parseFloat(itemband.fstartdl),
							fstopdl:parseFloat(itemband.fstopdl)												
								});


						});
					
					 ///aca sumamos los SN Asingados
							 if (data.snasignados== null)
								{
								
								}
								else
								{	
									tabla_info_show_po=tabla_info_show_po+"<tr><th><b>SN LIST</b></th><td></td><td></td><td></td></tr>";		
										$.each(data.snasignados, function(i, itemstock2) 
										{
										if( $("#qeneslogin").val() =='develop' || 'Productionadmin' == $("#qeneslogin").val())
											{
												tabla_info_show_po=tabla_info_show_po+"<tr><th class='colorazulfiplex'><b>SN assigned: </b>  </th><th class='colorazulfiplex'><b>"+itemstock2.wo_serialnumber+"</b></th> <td colspan='2'> <a href='unlinksndevelop.php?snmm="+itemstock2.wo_serialnumber+"' target='_blank'> <span class='text-danger'>Unlink sn </span> </a>  </td></tr>";			
											}
											else
											{
												tabla_info_show_po=tabla_info_show_po+"<tr><th class='colorazulfiplex'><b>SN assigned: </b>  </th><th class='colorazulfiplex'><b>"+itemstock2.wo_serialnumber+"</b></th> <td colspan='2'></td></tr>";			
											}
											
										});
								}
								
								var v_modulorabbit ='';
					 if (data.havemodulorabbit =='N')
					 {
						v_modulorabbit = '<span class="badge bg-danger">NO</span>';
					 }
					 if (data.havemodulorabbit =='Y')
					 {
						v_modulorabbit = '<span class="badge bg-success">YES</span>';
					 }
					 console.log('aca rabbit');
					 console.log(v_modulorabbit);

					 console.log('ABCCCCC');
					 console.log(data.resultadojson);
					 if (data.resultadojson !='')
					 {
						console.log('ABCCCCC');
						tabla_info_show_po=tabla_info_show_po+"<tr><td  colspan='2'>"+data.resultadojson +"</td><td></td><td></td></tr>";
					 }

					 if (data.isdigunit =='Y')
					 {
						if (v_modulorabbit !='')
						{
							tabla_info_show_po=tabla_info_show_po+"<tr><td><b>Include Rabbit Module: </b></td><td>"+v_modulorabbit+"</td><td></td><td></td></tr>";
						}
						else
						{
							if (data.ps[0].estacompletalaso =='Y')
							{
								
								tabla_info_show_po=tabla_info_show_po+"<tr><td class='text-danger'><b>Missing Definition Rabbit Module </b></td><td>Does this unit requires a rabbit module? <button type='button' class='btn btn-outline-success btn-sm'  onclick='setrabbit(1,"+vidpo+")'>Yes</button>&nbsp;&nbsp;&nbsp;<button type='button'  onclick='setrabbit(0,"+vidpo+")' class='btn btn-outline-danger  btn-sm'>No</button></td><td></td><td></td></tr>";
							}
							else
							{
								tabla_info_show_po=tabla_info_show_po+"<tr><td class='text-danger'><b>Missing Definition Rabbit Module </b></td><td>Does this unit requires a rabbit module? <button type='button' class='btn btn-outline-success btn-sm' onclick='setrabbit(1,"+vidpo+")'>Yes</button>&nbsp;&nbsp;&nbsp;<button type='button'  onclick='setrabbit(0,"+vidpo+")' class='btn btn-outline-danger  btn-sm'>No</button></td><td></td><td></td></tr>";
							}
							
						}
					 }
					 
				


								tabla_info_show_po=tabla_info_show_po+"<tr><td><br></td><td></td><td></td><td></td></tr>";		
								tabla_info_show_po=tabla_info_show_po+"<tr><td> <b>CIU: </b></td><td>"+data.ps[0].ciu+"</td><td> <b>Quantity: </b></td><td>"+data.ps[0].quantity+"</td></tr>";
								tabla_info_show_po=tabla_info_show_po+"<tr><th>Description CIU:<br></th><td colspan=3>"+data.ps[0].descripcionciu+"</td></tr>";	
					 
					  $("#txtcant").val(data.ps[0].quantity);
					  $('#txtcant').attr('min', data.ps[0].quantity);  
					  cantrequired = data.ps[0].quantity;
					 $("#poselecm").val(data.ps[0].idpresales);
					 $("#poselecmrev").val(data.ps[0].idrev);
					
					 $("#txtdescripso").val(data.ps[0].descripcion);
					 $("#txtnotepo").val(data.ps[0].notes);
					
					
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
				
					 
					// tabla_info_show_po=tabla_info_show_po+"<tr><th><b>UNIT (DL - UL) List</b></th><td></td><td></td><td></td></tr>";		
					var vv_ulgain="NA";
					var vv_dlgain="NA";
					var vv_ulmaxpwr="NA";
					var vv_dlmaxpwe="NA";

				

					 var note_unit = "";
					 $.each(data.psunit, function(i, itempsunit) {
							note_unit = itempsunit.notes;
								
							///tabla_info_show_po=tabla_info_show_po+"<tr><td>Unit DL: Start: <b>"+itempsunit.unitdlstart+"</b> MHz</td><td>Unit DL: Stop: <b>"+itempsunit.unitdlstop+"</b> MHz</td><td>Unit UL: Start: <b>"+itempsunit.unitulstart+"</b> MHz</td> <td>Unit UL: Stop: <b>"+itempsunit.unitulstop+"</b> MHz</td></tr>";		
								
							/*	tabla_gain_dlul.push({						
									gainudstart: parseFloat(itempsunit.unitdlstart),
									gainudstop: parseFloat(itempsunit.unitdlstop),
									gainulstart: parseFloat(itempsunit.unitulstart),
									gainulstop: parseFloat(itempsunit.unitulstop)
									*/

									tabla_gain_dlul_onlyshow.push({	
										Band:itempsunit.nomband,
														hiddengainudstart: parseFloat(itempsunit.unitdlstart),
														hiddengainudstop: parseFloat(itempsunit.unitdlstop),
														hiddengainulstart: parseFloat(itempsunit.unitulstart),
														hiddengainulstop: parseFloat(itempsunit.unitulstop), 
														DL_Start:  parseFloat(itempsunit.unitdlstart),
														DL_Stop: parseFloat(itempsunit.unitdlstop),
														UL_Start: parseFloat(itempsunit.unitulstart),
														UL_Stop:  parseFloat(itempsunit.unitulstop), 
														noteditUL_gain: parseFloat(itempsunit.ul_gain),
														noteditDL_gain: parseFloat(itempsunit.dl_gain),
														noteditUL_maxpwr: parseFloat(itempsunit.ul_max_pwr),
														noteditDL_maxpwr: parseFloat(itempsunit.dl_max_pwr)									
						 			  });

									 
									   if (itempsunit.ul_gain != null)
										{
											vv_ulgain= itempsunit.ul_gain ;
										}
										if (itempsunit.dl_gain != null)
										{
											vv_dlgain=itempsunit.dl_gain;
										}
									
										if (itempsunit.ul_max_pwr != null)
										{
											vv_ulmaxpwr=itempsunit.ul_max_pwr;
										}
										if (itempsunit.dl_max_pwr != null)
										{
											vv_dlmaxpwe= itempsunit.dl_max_pwr;
										}
									
									

									tabla_gain_dlul.push({	
										Band:itempsunit.nomband,
														hiddengainudstart: parseFloat(itempsunit.unitdlstart),
														hiddengainudstop: parseFloat(itempsunit.unitdlstop),
														hiddengainulstart: parseFloat(itempsunit.unitulstart),
														hiddengainulstop: parseFloat(itempsunit.unitulstop), 
														DL_Start:  parseFloat(itempsunit.unitdlstart),
														DL_Stop: parseFloat(itempsunit.unitdlstop),
														UL_Start: parseFloat(itempsunit.unitulstart),
														UL_Stop:  parseFloat(itempsunit.unitulstop), 
														noteditUL_gain: parseFloat(itempsunit.ul_gain),
														noteditDL_gain: parseFloat(itempsunit.dl_gain),
														noteditUL_maxpwr: parseFloat(itempsunit.ul_max_pwr),
														noteditDL_maxpwr: parseFloat(itempsunit.dl_max_pwr)									
						 			  });
						   
						});
						
						   
						  // tabla_gain_udul();
						  // lo puse al final tabla_gain_udul2dagen();
						
							//  tabla_info_show_po=tabla_info_show_po+"<tr><th>Note Unit:<br></th><td colspan=3>"+note_unit+"</td></tr>";	
							 tabla_info_show_po=tabla_info_show_po+"<tr><td><b>DL gain: </b></td><td>"+vv_dlgain+" (dB)</td><td><b>UL  gain:</b></td> <td>"+vv_ulgain+" (dB)</td></tr>";
							 tabla_info_show_po=tabla_info_show_po+"<tr><td><b>DL Max Pwr Out: </b></td><td>"+vv_dlmaxpwe+" (dBm)</td><td><b>UL 	Max Pwr Out:</b></td> <td>"+vv_ulmaxpwr+"  (dBm)</td></tr>";
					 
							 tabla_info_show_po=tabla_info_show_po+"<tr><th>PO Numbre:<br></th><td colspan=3>"+data.ps[0].ponumber+"</td></tr>";	
					  tabla_info_show_po=tabla_info_show_po+"<tr><th>Description PO:<br></th><td colspan=3>"+data.ps[0].descripcion+"</td></tr>";	
					  tabla_info_show_po=tabla_info_show_po+"<tr><th>Notes PO:<br></th><td colspan=3>"+data.ps[0].notes+"</td></tr>";			
					 tabla_info_show_po=tabla_info_show_po+"<tr><td><b>POWER SUPPLY TYPE:</b></td><td>"+data.ps[0].pwrsupplytype+"</td><td></td><td></td></tr>";
					 
					
					/* if (v_modulorabbit !='')
					 {
						tabla_info_show_po=tabla_info_show_po+"<tr><td><b>Include Rabbit Module: </b></td><td>"+v_modulorabbit+"</td><td></td><td></td></tr>";
					 }
					 else
					 {
						if (data.ps[0].estacompletalaso =='Y')
						{
							
							tabla_info_show_po=tabla_info_show_po+"<tr><td class='text-danger'><b>Missing Definition Rabbit Module </b></td><td>Does this unit requires a rabbit module? <button type='button' class='btn btn-outline-success btn-sm'  onclick='setrabbit(1,"+vidpo+")'>Yes</button>&nbsp;&nbsp;&nbsp;<button type='button'  onclick='setrabbit(0,"+vidpo+")' class='btn btn-outline-danger  btn-sm'>No</button></td><td></td><td></td></tr>";
						}
						else
						{
							tabla_info_show_po=tabla_info_show_po+"<tr><td class='text-danger'><b>Missing Definition Rabbit Module </b></td><td>Does this unit requires a rabbit module? <button type='button' class='btn btn-outline-success btn-sm' onclick='setrabbit(1,"+vidpo+")'>Yes</button>&nbsp;&nbsp;&nbsp;<button type='button'  onclick='setrabbit(0,"+vidpo+")' class='btn btn-outline-danger  btn-sm'>No</button></td><td></td><td></td></tr>";
						}
						
					 }*/
					 
				//	 tabla_info_show_po=tabla_info_show_po+"<tr><td><b>RC-G for BWA:</b></td><td>"+v_rcgfbwa+"</td><td><b>Moden for Digital:</b></td><td>"+v_moden_dig+" </td></tr>";
		
					////// list file attach
					 tabla_info_show_po=tabla_info_show_po+"<tr><td><br></td><td></td><td></td><td></td></tr></table>";

					 tabla_info_show_po=tabla_info_show_po+"<table class='table table-striped '><tbody><tr><td><b>List of Attached Files:</b> <hr>";
					 if (data.listattach != null)
					 {
						var v_seedtemp = "";
						$.each(data.listattach, function(i, itemplistatt) {

								let posicionpdf = itemplistatt.namefileattach2.indexOf('pdf');
								v_seedtemp = itemplistatt.seedtemp;

								if (itemplistatt.idordersfileat >0)
								{

								
										if (posicionpdf !== -1)
										{
											tabla_info_show_po=tabla_info_show_po+"<a href='' onclick='openpfgdownfileattaso(0,"+String.fromCharCode(34) +itemplistatt.namefileattach2+String.fromCharCode(34) +",0);return false;'><i class='fas fa-file-pdf' style='font-size:18px;color:red'></i>&nbsp; "+itemplistatt.namefileattach+" </a>";

											// solo Luciana o ADMINISTRATOS pueden borrar.
											if ( $("#puedeborrar").val()=="Y")
											{
												tabla_info_show_po=tabla_info_show_po+"&nbsp;||&nbsp;<a href='' onclick='delattachorigsn("+itemplistatt.idordersfileat +");return false;'> <i class='far fa-times-circle'></i> </a><br>"
											}
											else
											{
												tabla_info_show_po=tabla_info_show_po+"<br>";
											}
											
										}
										else
										{
											
											tabla_info_show_po=tabla_info_show_po+"<a href='' onclick='downfileattaso(0,"+String.fromCharCode(34) +itemplistatt.namefileattach2+String.fromCharCode(34) +",0)'><i class='fas fa-paperclip' style='font-size:18px'></i> "+itemplistatt.namefileattach+" </a><br>";
												// solo Luciana o ADMINISTRATOS pueden borrar.
												if ( $("#puedeborrar").val()=="Y")
											{
												tabla_info_show_po=tabla_info_show_po+"&nbsp;||&nbsp;<a href='' onclick='delattachorigsn("+itemplistatt.idordersfileat+");return false;'> <i class='far fa-times-circle'></i> </a><br>"
											}
											else
											{
												tabla_info_show_po=tabla_info_show_po+"<br>";
											}
										}

										//<i class="fas fa-file-pdf"></i>
										//window.open("Here Download PDF url", '_blank');
								  }

								});
					 }
					 tabla_info_show_po=tabla_info_show_po+"<hr><br><a href='' onclick='addfiletoso("+String.fromCharCode(34) +v_seedtemp+String.fromCharCode(34) +","+vidpo+");return false;'> <i class='far fa-plus-square' style='font-size:18px'></i> - Add files to SO</a>";
					//tabla_info_show_po=tabla_info_show_po+"<tr><td><a href='#' class='btn btn-block bg-gradient-primary btn-xs' style='color:#ffffff'  onclick='listattachfile(0,"+String.fromCharCode(34) + data.ps[0].so_soft_external+ String.fromCharCode(34) +",0)'>View attachments <i class='fas fa-paperclip' style='font-size:14px'></i></a><br><br></td><td></td><td></td><td></td></tr></table>";
					tabla_info_show_po=tabla_info_show_po+"</td></tr></table><br>";	
					 tabla_info_show_po=tabla_info_show_po+"<div class=' ' id='listadpx1' name='listadpx1'> </div>";		
					 tabla_info_show_po=tabla_info_show_po+"<div class='col-sm-12' id='listagainuldl1' name='listagainuldl1'> </div>";		

					 
					//  tabla_info_show_po=tabla_info_show_po+"<tr><th><br></th><td></td><td><br></td><td></td></tr>";		
				//	 tabla_info_show_po=tabla_info_show_po+"<tr><th><b>DPX (Low - High) List</b></th><td></td><td></td><td></td></tr>";		
					 $.each(data.psdpx, function(i, itempsdpx) {
						//	
						//		tabla_info_show_po=tabla_info_show_po+"<tr><td>DPX Low Start: <b>"+itempsdpx.dpxlowstart+"</b> MHz</td><td>DPX Low Stop: <b>"+itempsdpx.dpxlowstop+"</b> MHz</td><td>DPX High Start: <b>"+itempsdpx.dpxhihgstart+"</b> MHz</td> <td>DPX High Stop: <b>"+itempsdpx.dpxhihgstop+"</b> MHz</td></tr>";		
								
							 
						   	
										   tabla_dpx_solomuestra.push({	
														Band:itempsdpx.nomband,												
														dpxlowstart: parseFloat(itempsdpx.dpxlowstart),
														dpxlowstop:  parseFloat(itempsdpx.dpxlowstop),
														dpxhighstart: parseFloat(itempsdpx.dpxhihgstart),
														dpxhighstop: parseFloat(itempsdpx.dpxhihgstop),
														dpxlowstartcustom:parseFloat(itempsdpx.dpxlowstart),
														dpxlowstopcustom:   parseFloat(itempsdpx.dpxlowstop),
														dpxhighstartcustom:parseFloat(itempsdpx.dpxhihgstart),
														dpxhighstopcustom: parseFloat(itempsdpx.dpxhihgstop),
														});
														
						   
						});
				//	 list_tabla_dpx();
				// lo puse al final	 list_tabla_dpx_udul2dagen();

			

					 tabla_info_show_po=tabla_info_show_po+"<table class='table table-striped '>";		
					 tabla_info_show_po=tabla_info_show_po+"<tr><th><br></th><td></td><td><br></td><td></td></tr>";		
					 tabla_info_show_po=tabla_info_show_po+"<tr><th><b>Channels List</b></th><td></td><td></td><td></td></tr>";		
					 var note_unit_ch="";
					 $.each(data.psch, function(i, itempsch) {
						//	console.log(i +'muestro psch...itemdib:'+itempsch.totalpass);
								note_unit_ch = itempsch.notes;
								tabla_info_show_po=tabla_info_show_po+"<tr><td><b>DL Channels :</b></td><td><b>"+itempsch.dl_ch_fr+"</b> (MHz)</td><td><b>UL Channels :</b></td> <td><b>"+itempsch.ul_ch_fr+"</b> (MHz)</td></tr>";		
								
								 tabla_channel_quantity.push({						
							channeldl: parseFloat(itempsch.dl_ch_fr),
							channelul: parseFloat(itempsch.ul_ch_fr) ,
							idband: parseInt(itempsch.idband)	,	
							idbandname:  (itempsch.nameband)					
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
							//console.log(data.ps[0].ciu.substr(0,4));
							if (data.ps[0].ciu.substr(0,4) =="DH7S")
							{
							tabla_info_stock=tabla_info_stock+"<tr><td colspan='2'><input type='hidden' name='quiengenerarlossn' id='quiengenerarlossn' value=''>  </td><td colspan='2'> <button type='button' class='btn btn-block btn-outline-success' onclick='seleciongenerasn(2)' name='btnsn2' id='btnsn2'>Assign SN User</button> </td></tr>";	
							}
							else
							{
								tabla_info_stock=tabla_info_stock+"<tr><td colspan='2'><input type='hidden' name='quiengenerarlossn' id='quiengenerarlossn' value=''><button type='button' class='btn btn-block btn-outline-primary' onclick='seleciongenerasn(1)' name='btnsn1' id='btnsn1'>Assign SN FasServer</button>  </td><td colspan='2'> <button type='button' class='btn btn-block btn-outline-success' onclick='seleciongenerasn(2)' name='btnsn2' id='btnsn2'>Assign SN User</button> </td></tr>";
							}
						
							
							
							var cantasignado = 0;
								var cant_requerid_total = 0;
								cant_requerid_total = cantrequired ;
								
								if (data.snasignados== null)
								{
									cantasignado = 0;
								}
								else
								{	
									$.each(data.snasignados, function(i, itemstock2) 
									{
									//	console.log('sn asing:'+ itemstock2.wo_serialnumber);
										if ( itemstock2.wo_serialnumber != '')
										{
											cantasignado = cantasignado + 1;
										}
									
									});
								}
								console.log ('******cant sn asign'+ cantasignado);
						var idproducttemp=0;
						var autoselectsn =cantasignado+1;
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
												///// a pedido de franscesco y agus.. dejamos q elijan cualquiera.
												//ischequed ="checked";
											//	console.log('a');
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
											//	console.log('b'+autoselectsn);
												autoselectsn= autoselectsn+ 1 ;		
														//a pedido de Francesco
												ischequed ="";
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
							
								cantrequired = cantrequired - cantasignado;
				     //    console.log ('cant sn asign'+ cantasignado);
								var varpermiso_assing_sn = '<?php echo $permiso_assing_sn;?>';							
								if (varpermiso_assing_sn =='Y'   )
								{
									//// pregunta si tiene asignado SALEORDES
									////if (data.ps[0].so_soft_external=='' ||  data.ps[0].estacompletalaso =='Y' )
									//no estamos usando mas estacompletalaso
									if (data.ps[0].so_soft_external==''  )
									{
										tabla_info_stock=tabla_info_stock+"<tr><td><b>Quantity Required SO :"+cant_requerid_total+"<br> Remaining amount : "+cantrequired+"</b> <input type='hidden' value='"+cantrequired+"' name='vhcantrequerida' id='vhcantrequerida'> </td><td><b>Selected quantity: <input type='hidden'  id='vhcantselect' name='vhcantselect' value="+autoselectsn+"> <span id='cantselect'>"+autoselectsn+"</span></b></td> <td colspan='2'><button type='button' class='btn btn-primary btn-block' id='btnchangep_chirs' disabled name='btnchangep_chirs'>Assign SN ..</button></td></tr>";		
									}
									else
									{
										tabla_info_stock=tabla_info_stock+"<tr><td><b>Quantity Required SO :"+cant_requerid_total+"<br> Remaining amount :"+cantrequired+"</b> <input type='hidden' value='"+cantrequired+"' name='vhcantrequerida' id='vhcantrequerida'></td><td><b>Selected quantity: <input type='hidden'  id='vhcantselect' name='vhcantselect' value="+autoselectsn+"> <span id='cantselect'>"+autoselectsn+"</span></b></td> <td colspan='2'><button type='button' class='btn btn-primary btn-block' id='btnchangep_chirs' onclick='savechristian()' name='btnchangep_chirs'>Assign SN</button></td></tr>";										
									}
									
								}
								else
								{
								tabla_info_stock=tabla_info_stock+"<tr><td><b>Quantity Required SO :"+cant_requerid_total+"<br> Remaining amount : "+cantrequired+"</b> <input type='hidden' value='"+cantrequired+"' name='vhcantrequerida' id='vhcantrequerida'> </td><td><b>Selected quantity: <input type='hidden'  id='vhcantselect' name='vhcantselect' value="+autoselectsn+"> <span id='cantselect'>"+autoselectsn+"0</span></b></td> <td colspan='2'><button type='button' class='btn btn-primary btn-block' id='btnchangep_chirs' disabled name='btnchangep_chirs'>Assign SN ....</button></td></tr>";		
								}
							
								if (data.snasignados== null)
								{
									cantasignado = 0;
								}
								else
								{
										$.each(data.snasignados, function(i, itemstock2) 
										{
										tabla_info_stock=tabla_info_stock+"<tr><td><b>SN assigned: </b>  </td><td><b>"+itemstock2.wo_serialnumber+"</b></td> <td colspan='2'></td></tr>";			
										});
								}
							
							
								$('#kkasign').val(cantasignado);
							tabla_info_stock=tabla_info_stock +"</table>";
							tabla_info_stock=tabla_info_stock +"<div class='info-box'><span class='info-box-icon bg-yellow '><i class='fas fa-cogs'></i></span><div class='info-box-content'><a href='generawororder.php'><span class='info-box-number'>Create New Work Orders  </span></a></div></div>";
							  
								$('#cuiparachir').html(tabla_info_stock);
								//marcoaca deshabilito los checkbox
								$("input:checkbox").attr('disabled', true);
								$("input:checkbox").attr('disabled', true);
						//	console.log("Final nuevo"+tabla_info_stock);
							//$('#lblvuser').text(datax.vuser.replace("#"," "));
							//$('#lblvdevice').text(datax.vdecice.replace("#"," "));	
						
						///	tabla_gain_udul2dagen_solomuestra();


						list_tabla_dpx_udul2dagen();
						list_tabla_dpx_udul2dagen_solomuestra();
						
					  					
							
					
					///TEMPORAL hasta q veamos si tengo q elegir YO el SN O FAS Server$("#btnsn2").html("Assign SN User <i class='fas fa-check'></i>");
						//console.log('temporal' + tabla_info_stock);
						$("#btnsn1").html("Assign SN FasServer ");
						$("#btnsn1").hide();
						$("#btnsn2").html("Assign SN User <i class='fas fa-check'></i>");
						$("#quiengenerarlossn").val(2);
						$("input:checkbox").attr('disabled', false);
						
					//////////////upgrade
						$("#sosnupgrade").html(" ");

						$.ajax
						({ 
							url: 'setshow_upgrade_orderinfo.php',
							data: "idsoup="+vidpo,	
							type: 'post',				
							datatype:'JSON',                
							success: function(dataupgrade)
							{
								$("#sosnupgrade").html(dataupgrade);
							}
						});
						
					/////// fin upgrde	
			 
				}
			 
				
				
			});
			
	}

	function setrabbit(haverab, idord) 
	{
		var sssrt="";
		if (haverab ==1)
		{
			sssrt="YES";
		}
		else
		{
			sssrt="NO";
		}

	/*	Swal.fire({
			title: 'Are you sure?',
			text: "Configure Module Rabbit : " + sssrt,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes!'
			}).then((result) => {
			if (result.isConfirmed) {
				Swal.fire(
				'Deleted!',
				'Your file has been deleted.',
				'success'
				)
			}
			})*/

			const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success',
    cancelButton: 'btn btn-danger'
  },
  buttonsStyling: false
})

swalWithBootstrapButtons.fire({
  title: 'Are you sure?',
  text: "Configure Module Rabbit : " + sssrt,
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: ' Yes ',
  cancelButtonText: ' No ',
  reverseButtons: true
}).then((result) => {
	console.log(result);
  if (result.value) {
	

/////////////////////////// envio datos
$.ajax({
										url: 'ajaxsectmodrabbit.php?ido='+idord+'&st='+haverab,										
										 cache:false,
										success: function(respuesta) {
											console.log(respuesta);
											if (respuesta.value='ok')
											{
												Swal.fire('Saved!', '', 'success')
												window.location.href= 'listpresales.php';
											}

											
										},
										error: function() {
											console.log("No se ha podido obtener la información");
											 
										}
									});
/////////////////////////// fin envio datos

  } else if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelled',
      '',
      'error'
    )
  }
})

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
								//	console.log ('-aaa' +cb.attr('name') +'----*:'+ cb.attr('checked'));	
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
	  // console.log( va1 +'aaaaaa'+ va2 );
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

			  if(va1==0)
			  {
				alert('Has no SN pending to assign');
			  }	
			  else
			  {

			  console.log('va1 y va2');
			  console.log(va1);
			  console.log(va2);

					if ( parseInt(va1)>=parseInt(va2))
					{
						console.log('si va1 y va2');
									/////////////////////////////////////////////////////
											var vvnroso  = document.getElementById("txtsoluumber").value; 
											var vidpo = document.getElementById("poselecm").value; 			
												$('input[type=checkbox]').each(function(){
												var cb = $(this);					
													if( typeof cb.attr('name') === 'undefined' ||cb.attr('name') === null )
													{
													}
													else
													{
															if (cb.attr('name').length > 8)
															{
																if ('chkstock' == cb.attr('name').substring(0,8) )
																{
																		if($("#"+cb.attr('name')).is(':checked')) 
																		{  
																	
																			los_sn_seleccionados=los_sn_seleccionados+$("#"+cb.attr('name')).val()+'#';
																				
																		}  													
																}
															}
													}						
												});
								
								
												if (los_sn_seleccionados != "")
												{
												
											
													var vkkasign =  $('#kkasign').val(); 
														$.ajax
														({ 
															url: 'ajax_update_po_so_sn.php',
															data: "idpo="+vidpo+'&so='+vvnroso+'&lossn='+los_sn_seleccionados+'&cantasing='+vkkasign,	
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
												}
												else
												{
													alert('Select SN');
												}
									/////////////////////////////////////////////////////			
						}
						else
						{
							alert('you must select the same amount');
						}
				}
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
		var esUHFVHF=0;
		var htmlmejorado='	<table class="table table-striped table-bordered table-sm"><thead >    <tr ><th class="table-dark text-center" scope="col">#</th> <th class="table-primary text-center" colspan=4 scope="col">DOWNLINK </th><th  class="table-info text-center" colspan=4 scope="col">UPLINK</th> </tr>';
		htmlmejorado += '<tr> <th width="80px"  class="table-dark text-center"  style="width: 10px">Band</th> <th  class="table-primary text-center" >Start </th> <th  class="table-primary text-center" >Stop </th><th  class="table-primary text-center" >Gain </th><th  class="table-primary text-center" >Max Pwr</th> <th  class="table-info text-center">Start </th><th  class="table-info text-center">Stop </th><th  class="table-info text-center">Gain </th> <th  class="table-info text-center">Max Pwr</th>  </thead> <tbody>';
		
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
		//	console.log(tabla_gain_dlul[0]);
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
//console.log('a'+ tabla_gain_dlul[i].Band.indexOf('700') );
//console.log('b'+ tabla_gain_dlul[i].Band.indexOf('800'));
			if (tabla_gain_dlul[i].Band.indexOf('700') >=0 || tabla_gain_dlul[i].Band.indexOf('800')>=0)	
			{
				htmlmejorado += '<tr><th width="80px" scope="row">'+tabla_gain_dlul[i].Band+'</th>	<td  width="80px" class=" text-center  id'+i+'#DL_Start'+'" id="id'+i+'#DL_Start" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#DL_Start'+"'"+','+i+')" >'+tabla_gain_dlul[i].hiddengainudstart+' </td>	<td width="80px" class=" text-center  id'+i+'#DL_Stop'+'" id="id'+i+'#DL_Stop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#DL_Stop'+"'"+','+i+')" >'+tabla_gain_dlul[i].hiddengainudstop+' </td><td class=" text-center" >'+tabla_gain_dlul[i].noteditDL_gain+' dB </td><td class=" text-center" >'+tabla_gain_dlul[i].noteditDL_maxpwr+' dBm</td>';
				htmlmejorado += '<td  width="80px" class=" text-center  id'+i+'#UL_Start'+'" id="id'+i+'#UL_Start" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#UL_Start'+"'"+','+i+')"  >'+tabla_gain_dlul[i].hiddengainulstart+' </td><td width="80px" class=" text-center  id'+i+'#UL_Stop'+'" id="id'+i+'#UL_Stop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#UL_Stop'+"'"+','+i+')" >'+tabla_gain_dlul[i].hiddengainulstop+' </td><td  class=" text-center">'+tabla_gain_dlul[i].noteditUL_gain+' dB</td>';
			console.log('aver4'+	isNaN(tabla_gain_dlul[i].noteditUL_maxpwr));
				if(isNaN(tabla_gain_dlul[i].noteditUL_maxpwr))
				{
					htmlmejorado += ' <td   class=" text-center" >missing information </td> ';
				}
				else
				{
					htmlmejorado += ' <td  class=" text-center" >'+tabla_gain_dlul[i].noteditUL_maxpwr+' dBm </td> ';
				}
			
			
			}
			else
			{
				if (esUHFVHF==0 ||esUHFVHF==2)
				{
 					//console.log('esUHFVHF:'+esUHFVHF+ '--buscamos:' +tiene2UHF);
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

				htmlmejorado += '<tr><th width="80px" scope="row">'+nombandper +'</th>	<td  width="80px" class=" text-center '+v_temp_DL_Startclass+' id'+i+'#DL_Start'+'" id="id'+i+'#DL_Start" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#DL_Start'+"'"+','+i+')"  contenteditable="true">'+v_temp_DL_Start+' </td>	<td width="80px" class=" text-center '+v_temp_DL_Stopclass+' id'+i+'#DL_Stop'+'" id="id'+i+'#DL_Stop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#DL_Stop'+"'"+','+i+')"  contenteditable="true">'+v_temp_DL_Stop+' </td><td class=" text-center" >'+tabla_gain_dlul[i].noteditDL_gain+' dB </td><td class=" text-center" >'+tabla_gain_dlul[i].noteditDL_maxpwr+' dBm</td>';
				htmlmejorado += '<td  width="80px" class=" text-center '+v_temp_Startclass+' id'+i+'#UL_Start'+'" id="id'+i+'#UL_Start" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#UL_Start'+"'"+','+i+')"  contenteditable="true">'+v_temp_Start+' </td><td width="80px" class=" text-center '+v_temp_UL_Stopclass+' id'+i+'#UL_Stop'+'" id="id'+i+'#UL_Stop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#UL_Stop'+"'"+','+i+')"  contenteditable="true">'+v_temp_UL_Stop+' </td><td  class=" text-center">'+tabla_gain_dlul[i].noteditUL_gain+' dB</td>';
				console.log('aver14-'+	isNaN(tabla_gain_dlul[i].noteditUL_maxpwr));		
					if(isNaN(tabla_gain_dlul[i].noteditUL_maxpwr))
					{
						htmlmejorado += ' <td  class=" text-center" >missing information</td> ';
					}
					else
					{
						htmlmejorado += ' <td  class=" text-center" >'+tabla_gain_dlul[i].noteditUL_maxpwr+' dBm </td> ';
					}
				}
			}
		
			/// Validamos UHF VHF
					if (tabla_gain_dlul[i].Band.indexOf('UHF')>=0)
						{
							esUHFVHF=esUHFVHF+1;	
						}
						if (tabla_gain_dlul[i].Band.indexOf('VHF')>=0)
						{
						//	esUHFVHF=1;	
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
										html += '<td width="80px" contenteditable="true" id="id'+i+'#'+j+'" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#'+j+"'"+','+i+')" class=" colorfondonaranja id'+i+'#'+j+'"> -missing info -</td>';	  
									}
									else
									{
										html += '<td width="80px" contenteditable="true" id="id'+i+'#'+j+'" onkeypress="return soloNumeros(event)" class="id'+i+'#'+j+'" onblur="modif_table_array('+"'id"+i+'#'+j+"'"+','+i+')">  ' + tabla_gain_dlul[i][j]  +' MHz</td>';	  
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
			//	 console.log(v_templistchannel);
				 ///	$('#listagainuldl').html(html+'<br><br>'+htmlmejorado);
					 $('#listagainuldl').html(htmlmejorado);
					 $('#listagainuldl1').html(htmlmejorado);
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
						 html += '<th>' + jname + '</th>';
					 }
					  if (j =='channelul')
					 {
						 jname="UL Channels (MHz)";
						 html += '<th>' + jname + '</th>';
					 }
					 if ( j =='idbandname')
					 {
						 jname="Band";
						 html += '<th>' + jname + '</th>';
					 }
					 
				//  html += '<th>' + jname + '</th>';
				
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
					 
				//	console.log(j +'->'+ tabla_channel_quantity[i][j] );
						if(j =='idband' || j =='idbandname')
						{
							if ( j =='idband')
							{
							html += '<td>' +  tabla_bandas_paravaludar.find(x => x.idband === tabla_channel_quantity[i][j]).descband +' </td>';	  
						//	html += '<td>' +  tabla_channel_quantity[i][j]  +' </td>';	  
						//	tabla_bandas_paravaludar
							}
						
						}
						else
						{
							html += '<td>' + tabla_channel_quantity[i][j]  +'  MHz</td>';	  
						}
						
						v_templistchannel = v_templistchannel  + tabla_channel_quantity[i][j] + "|"
					
					
				  }
				  html += '<td>  <a href="#" onclick="borrar_array_channel('+i+')"> <i class="fas fa-trash-alt"></i> Del</a> </td>';	  
				  html += '</tr>';
				 }
				 html += '</table>';
				 v_templistchannel = v_templistchannel + "#";  
			//	 console.log(v_templistchannel);
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
		// Si tiene DPX lo dejo cargar...
		if ( tabla_dpx.length >= 1 )
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
						var idbandencontrado = 99;
						/// Buscamos el id band
							for (var i = 0; i < tabla_bandas_paravaludar.length; i++) {
							/*if (tabla_bandas_paravaludar[i].fstartul === value) {
								return array[i];
							}*/
							if ( parseInt(tabla_bandas_paravaludar[i].fstartul)  <= parseInt(v_ul_channel) && parseInt(tabla_bandas_paravaludar[i].fstopul)  >= parseInt(v_ul_channel)   )
							{
								if ( parseInt(tabla_bandas_paravaludar[i].fstartdl)  <= parseInt(v_dl_channel) && parseInt(tabla_bandas_paravaludar[i].fstopdl)  >= parseInt(v_dl_channel)   )
									{
										idbandencontrado =  tabla_bandas_paravaludar[i].idband;
									}
									else
									{
									//	alert(" out of range DL"); 	
									}
							}
							else
							{
							//	alert(" out of range UL"); 	
							}
							//	
						}
			//	console.log('ab idbandencontrado:'+ idbandencontrado);
						if (idbandencontrado<99)
						{
							tabla_channel_quantity.push({						
							channeldl: parseFloat(v_dl_channel),
							channelul: parseFloat(v_ul_channel),
							idband: idbandencontrado,
							idbandname:   tabla_bandas_paravaludar.find(x => x.idband === idbandencontrado).descband 
						
							});
							tabla_channels();
						}
						else
						{
							alert(" out of range "); 	
						}


						
							
							 
							$('#txtchud').val('');
							$('#txtchul').val('');
							
							 $("#txtchud").focus();
							  $("#txtchud").focus();
							  
					}
		  }	 
		}
		else
		{
			alert('duplexers are required to load a channel ');
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
			tabla_dpx_solomuestra.splice(idborrarch, 1); 
			
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
				 
			//	 console.log(html);
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
				$("#btnsn1").hide();
				$("#quiengenerarlossn").val(2);
				$("input:checkbox").attr('disabled', false);
			}
			
			
		}

 

		function openpfgdownfileattaso(idt,nomfilattdon ,idtm)
		{

		 
 
			window.open("https://webfas.honeywell.com/attachso/"+nomfilattdon, '_blank');
			return false;
			
		}
		function downfileattaso(idt,nomfilattdon ,idtm)
		{
			var a = document.createElement('a');
			a.setAttribute('href', 'https://webfas.honeywell.com/attachso/'+nomfilattdon);
			a.setAttribute('download', nomfilattdon);

			var aj = $(a);
			aj.appendTo('body');
			aj[0].click();
			aj.remove();
		}
		
		function save_new_rev()
		{
			var hagopost = 'S';
			if (document.getElementById("poselecm").value!="" ) 
			{				
				var xcantfaltantes = document.getElementsByClassName("colorfondonaranja");
				if (  xcantfaltantes.length ==0 )	
				{
					//if ( document.getElementById("txthavemodulerabbit").value!=""   )
					//{
						document.getElementById("myform").submit();
				//	}
				//	else
				//	{
				//		hagopost = 'N';
				//	 alert( " Rabbit Module is required. ");
				//	}
					
				}
				else
				{
 					hagopost = 'N';
					 alert( "DPX (DL - UL) List is required. ");
				}

					 

			}
			
		}
		
		    function show_ciu_version2020(idsaleorders, nameSO_Customers)
   {
	   var lbl_color ="";
		//alert('hi' + $('#collapse'+idsaleorders).is(":hidden"));
		if ($('#collapse'+idsaleorders).is(":hidden") == true)
		{
		
			$('#collapse'+idsaleorders).html("<p name='msjwaitparticular' id='msjwaitparticular' align='center'><img src='img/waitazul.gif' width='80px' ></p>");
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
   
   
   function delete_po(idpoaborrar)
	{
		
		Swal.fire({
							  title: 'Delete SO!',
							  text: "Are you sure ?",							
							  showCancelButton: true,
							  confirmButtonColor: '#3085d6',
							  cancelButtonColor: '#d33',
							  confirmButtonText: 'Yes',
							  cancelButtonText: 'No', 
							}).then((result) => {
							  if (result.value) 
							  {
								  
								  //aca inactivamos el WO.
								  $.ajax
									({ 
										url: 'ajax_delete_po.php',
										data: "idwo="+idpoaborrar,	
										type: 'post',				
										datatype:'JSON',                
										success: function(data)
										{
										//	alert(data.resultiu);
											if (data.result == 'ok')
											{
												alert('Delete SO!');									
												window.location = 'listpresales.php';
											}
											else
											{
													alert('Error deleting a WO!');	
											}
											
											///alert(data.result);
										}
									});	
								  
							//	window.location="listwordorder.php?delete=Y&idwo="+idpoaborrar; 
							  }
							  else
							  {
								 window.location="listpresales.php";
							  }
							})


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
	//		console.log('las cant'+ tempchdl.length +'-las cant2:'+ tempchul.length )
			for (i = 0; i < tempchdl.length; i++) {
					///Agrego canales.
		//			console.log('recorremos:'+  tempchdl[i] );
					if (  tempchdl[i] !='')
					{



						var idbandencontrado = 99;
						/// Buscamos el id band
						for (var iaa = 0; iaa < tabla_bandas_paravaludar.length; iaa++) {
							/*if (tabla_bandas_paravaludar[i].fstartul === value) {
								return array[i];
							}*/
							if ( parseInt(tabla_bandas_paravaludar[iaa].fstartul)  <= parseInt(tempchul[i]) && parseInt(tabla_bandas_paravaludar[iaa].fstopul)  >= parseInt(tempchul[i])   )
							{
								if ( parseInt(tabla_bandas_paravaludar[iaa].fstartdl)  <= parseInt( tempchdl[i]) && parseInt(tabla_bandas_paravaludar[iaa].fstopdl)  >= parseInt( tempchdl[i])   )
									{
										idbandencontrado =  tabla_bandas_paravaludar[iaa].idband;
									}
									else
									{
									//	alert(" out of range DL"); 	
									}
							}
							else
							{
							//	alert(" out of range UL"); 	
							}
							//console.log('abc:'+ tabla_bandas_paravaludar[i].fstartul);
						}
				//		console.log('ch impor idbandencontrado:'+ idbandencontrado);
						if (idbandencontrado<99)
						{
							tabla_channel_quantity.push({						
							channeldl: tempchdl[i],
							channelul: tempchul[i],
							idband: idbandencontrado,
							idbandname:   tabla_bandas_paravaludar.find(x => x.idband === idbandencontrado).descband 
							});

						}
						else
						{
							alert(" out of range"); 	
							/*tabla_channel_quantity.push({						
							channeldl: tempchdl[i],
							channelul: tempchul[i],
							idband: idbandencontrado						
							});*/
						}
					

					
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

	function list_tabla_dpx_udul2dagen_solomuestra()
	{

		///solo muestra los datos del array tabla_dpx_solomuestra que tiene los datos cargados en orders_sn_specs
		var jname ="";
		var v_temp_dpx="";

		var mindpxstartLOW = 99999;
		var mindpxstopLOW = 0;
		var mindpxstartHIGH = 99999;
		var mindpxstopHIGH = 0;

		var htmlmejoradodpx='	<table class="table table-striped table-bordered table-sm"><thead >    <tr ><th class="table-dark text-center" scope="col">#</th> <th class="table-primary text-center" colspan=2 scope="col">DOWNLINK </th><th  class="table-info text-center" colspan=2 scope="col">UPLINK </th> </tr>';
		htmlmejoradodpx += '<tr> <th width="100px"  class="table-dark text-center"  style="width: 10px">Band</th> <th  class="table-primary text-center" >DPX Low Start </th> <th  class="table-primary text-center" >DPX Low Stop </th><th  class="table-info text-center" >DPX High Start </th><th  class="table-info text-center" >DPX High Stop </th> </tr> </thead> <tbody>';
			
	//		console.log(tabla_dpx_solomuestra);
				 $.each(tabla_dpx_solomuestra, function(i, itempsdpx) {
					htmlmejoradodpx=htmlmejoradodpx+"<tr class='text-center'><td>"+itempsdpx.Band+"</td><td><b>"+itempsdpx.dpxlowstart+"</b> MHz</td><td><b>"+itempsdpx.dpxlowstop+"</b> MHz</td><td> <b>"+itempsdpx.dpxhighstart+"</b> MHz</td> <td> <b>"+itempsdpx.dpxhighstop+"</b> MHz</td></tr>";		
								
							 
						   	
						   
						});

		/*	for( var i = 0; i < tabla_dpx.length; i++) 
			{
			//	console.log(tabla_dpx[0]);
				var v_temp_DL_Start='';
				var v_temp_DL_Startclass='';

			
				if (tabla_dpx[i].Band.indexOf('700') >=0 || tabla_dpx[i].Band.indexOf('800')>=0)	
				{
					htmlmejoradodpx += '<tr><th width="100px" scope="row">'+tabla_dpx[i].Band+  '</th>	<td  width="150px" class=" text-center  id'+i+'#dpxhighstart'+'" id="id'+i+'#dpxhighstart" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#dpxhighstart'+"'"+','+i+')" >'+tabla_dpx[i].dpxlowstartcustom +' MHz</td>	<td width="150px" class=" text-center  id'+i+'#dpxhighstop'+'" id="id'+i+'#dpxhighstop" >'+tabla_dpx[i].dpxlowstopcustom +' MHz</td>';
					htmlmejoradodpx += '<td  width="150px" class=" text-center  id'+i+'#dpxlowstart'+'" id="id'+i+'#dpxlowstart"  >'+tabla_dpx[i].dpxhighstartcustom+' MHz</td>	<td width="150px" class=" text-center  id'+i+'#dpxlowstop'+'" id="id'+i+'#dpxlowstop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#dpxlowstop'+"'"+','+i+')" >'+tabla_dpx[i].dpxhighstopcustom+' MHz</td>';
				
				}
				else
				{
					v_temp_dpxlowstartcustom='';
					v_temp_dpxlowstartcustomclass='colorfondosolomnaranja';
				//	console.log('tabla_dpx[i].dpxlowstartcustom:'+tabla_dpx[i].dpxlowstartcustom);
				///console.log('a Ver es full band'+ tabla_dpx[i].isfullband + '+--------'+ isBoolean( tabla_dpx[i].isfullband)  );
						if (tabla_dpx[i].isfullband === true	)
						{						 
							v_temp_dpxlowstartcustom=tabla_dpx[i].dpxlowstart + ' MHz';
							v_temp_dpxlowstartcustomclass='';
							mindpxstartLOW=tabla_dpx[i].dpxlowstart;
						}
						if (tabla_dpx[i].isfullband == 'show'	)
						{						 
							v_temp_dpxlowstartcustom=tabla_dpx[i].dpxlowstartcustom + ' MHz';
							v_temp_dpxlowstartcustomclass='';
							mindpxstartLOW=tabla_dpx[i].dpxlowstartcustom;
						}
				 

						v_temp_dpxlowstopcustom='';
						v_temp_dpxlowstopcustomomclass='colorfondosolomnaranja';
						if (tabla_dpx[i].isfullband === true	)
						{						 
							v_temp_dpxlowstopcustom=tabla_dpx[i].dpxlowstop + ' MHz';
							v_temp_dpxlowstopcustomomclass='';
							mindpxstopLOW=tabla_dpx[i].dpxlowstop ;
						}

						if (tabla_dpx[i].isfullband == 'show'	)
						{						 
							v_temp_dpxlowstopcustom=tabla_dpx[i].dpxlowstopcustom + ' MHz';
							v_temp_dpxlowstopcustomomclass='';
							mindpxstopLOW=tabla_dpx[i].dpxlowstopcustom ;
						}
			

						v_temp_dpxhighstartcustom='';
						v_temp_dpxhighstartcustomclass='colorfondosolomnaranja';
						if (tabla_dpx[i].isfullband === true	)
						{						 
							v_temp_dpxhighstartcustom=tabla_dpx[i].dpxhighstart + ' MHz';
							v_temp_dpxhighstartcustomclass='';
							mindpxstartHIGH=tabla_dpx[i].dpxhighstart;
						}
						if (tabla_dpx[i].isfullband == 'show'	)
						{						 
							v_temp_dpxhighstartcustom=tabla_dpx[i].dpxhighstartcustom + ' MHz';
							v_temp_dpxhighstartcustomclass='';
							mindpxstartHIGH=tabla_dpx[i].dpxhighstartcustom;
						}

		
						v_temp_dpxhighstopcustom='';
					v_temp_dpxhighstopcustomclass='colorfondosolomnaranja';
					if (tabla_dpx[i].isfullband === true	)
						{						 
							v_temp_dpxhighstopcustom=tabla_dpx[i].dpxhighstop + ' MHz';
							v_temp_dpxhighstopcustomclass='';
							mindpxstopHIGH=tabla_dpx[i].dpxhighstop;
						}
						if (tabla_dpx[i].isfullband =='show'	)
						{						 
							v_temp_dpxhighstopcustom=tabla_dpx[i].dpxhighstopcustom + ' MHz';
							v_temp_dpxhighstopcustomclass='';
							mindpxstopHIGH=tabla_dpx[i].dpxhighstopcustom;
						}

			 
					
						for( var immxx = 0; immxx < tabla_dpx[i].qband; immxx++) 
						{
							imm = tabla_dpx[i].idarray;
							htmlmejoradodpx += '<tr><th width="100px" scope="row"> '+tabla_dpx[i].Band+'   &nbsp;&nbsp; <a href="#"  title="Delete the DPX"><i class="fas fa-times-circle"></i></a>   </th>';
						htmlmejoradodpx += '<td  width="150px"  contenteditable="false" class=" text-center '+v_temp_dpxlowstartcustomclass+'  id'+imm+'#dpxlowstartcustom'+'" id="id'+imm+'#dpxlowstartcustom"  >'+v_temp_dpxlowstartcustom+' </td>';
						htmlmejoradodpx +='	<td width="150px"   contenteditable="false" class=" text-center '+v_temp_dpxlowstopcustomomclass+'  id'+imm+'#dpxlowstopcustom'+'" id="id'+imm+'#dpxlowstopcustom"  >'+v_temp_dpxlowstopcustom+' </td>';
						htmlmejoradodpx += '<td  width="150px" contenteditable="false" class=" text-center '+v_temp_dpxhighstartcustomclass+'  id'+imm+'#dpxhighstartcustom'+'" id="id'+imm+'#dpxhighstartcustom"  >'+v_temp_dpxhighstartcustom+' </td>';
						htmlmejoradodpx +=	'<td width="150px"  contenteditable="false" class=" text-center '+v_temp_dpxhighstopcustomclass+'  id'+imm+'#dpxhighstopcustom'+'" id="id'+imm+'#dpxhighstopcustom"  >'+v_temp_dpxhighstopcustom+' </td>';
					
						}

			
				/// AutoFill a las Unit

				}	

					mindpxstartLOW = 99999;
					mindpxstopLOW = 0;
					mindpxstartHIGH = 99999;
					mindpxstopHIGH = 0;
					
			}*/
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
				  html += '<td>   </td>';	  
				  html += '</tr>';
				 }
				 html += '</table>';
				 v_temp_dpx = v_temp_dpx + "#";  
				// console.log(v_temp_dpx);
				 
					 $('#listadpx1').html(htmlmejoradodpx);
			 
	}


	function delattachorigsn(idfileatttodel)
{
/// inicio del
	
//console.log(idfileatttodel);
//console.log(nombrefile);

Swal.fire({
title:'are you sure you want to delete  from the SO ?',						
  inputAttributes: {
    autocapitalize: 'off'
  },
  showCancelButton: true,
  cancelButtonText:'No',
    confirmButtonText: 'Yes',
  showLoaderOnConfirm: true,
  preConfirm: (login) => {
	 // alert(login);
	  if (login =='')
	  {
		 
        
	  }
	  else
	  {
		  allowOutsideClick: () => !Swal.isLoading()

      var vv_idp = $("#projectdraft").val();
        var vv_idprev = $("#projectdraftrev").val();
    
	 
		return fetch('delattachprojflexsooriginorders.php?v2='+idfileatttodel)
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
  if (result.value.ok=="ok") {
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
           window.location = 'listpresales.php';
              	
							})
  }
  else
  {
	  alert('Error');
  }
})

///fin del
}


function  list_tabla_dpx_udul2dagen()
	{
		var jname ="";
		var v_temp_dpx="";

		var mindpxstartLOW = 99999;
		var mindpxstopLOW = 0;
		var mindpxstartHIGH = 99999;
		var mindpxstopHIGH = 0;

		var htmlmejoradodpx='	<table class="table table-striped table-bordered table-sm"><thead >    <tr ><th class="table-dark text-center" scope="col">#</th> <th class="table-primary text-center" colspan=2 scope="col">DOWNLINK </th><th  class="table-info text-center" colspan=2 scope="col">UPLINK </th> </tr>';
		htmlmejoradodpx += '<tr> <th width="100px"  class="table-dark text-center"  style="width: 10px">Band</th> <th  class="table-primary text-center" >DPX Low Start </th> <th  class="table-primary text-center" >DPX Low Stop </th><th  class="table-info text-center" >DPX High Start </th><th  class="table-info text-center" >DPX High Stop </th> </tr> </thead> <tbody>';
			
			for( var i = 0; i < tabla_dpx.length; i++) 
			{
			//	console.log(tabla_dpx[0]);
				var v_temp_DL_Start='';
				var v_temp_DL_Startclass='';

			
				if (tabla_dpx[i].Band.indexOf('700') >=0 || tabla_dpx[i].Band.indexOf('800')>=0)	
				{
					htmlmejoradodpx += '<tr><th width="100px" scope="row">'+tabla_dpx[i].Band+  '</th>	<td  width="150px" class=" text-center  id'+i+'#dpxhighstart'+'" id="id'+i+'#dpxhighstart" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#dpxhighstart'+"'"+','+i+')" >'+tabla_dpx[i].dpxlowstartcustom +' MHz</td>	<td width="150px" class=" text-center  id'+i+'#dpxhighstop'+'" id="id'+i+'#dpxhighstop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#dpxhighstop'+"'"+','+i+')" >'+tabla_dpx[i].dpxlowstopcustom +' MHz</td>';
					htmlmejoradodpx += '<td  width="150px" class=" text-center  id'+i+'#dpxlowstart'+'" id="id'+i+'#dpxlowstart" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#dpxlowstart'+"'"+','+i+')" >'+tabla_dpx[i].dpxhighstartcustom+' MHz</td>	<td width="150px" class=" text-center  id'+i+'#dpxlowstop'+'" id="id'+i+'#dpxlowstop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#dpxlowstop'+"'"+','+i+')" >'+tabla_dpx[i].dpxhighstopcustom+' MHz</td>';
				
				}
				else
				{
					v_temp_dpxlowstartcustom='';
					v_temp_dpxlowstartcustomclass='colorfondonaranja';
				//	console.log('tabla_dpx[i].dpxlowstartcustom:'+tabla_dpx[i].dpxlowstartcustom);
				///console.log('a Ver es full band'+ tabla_dpx[i].isfullband + '+--------'+ isBoolean( tabla_dpx[i].isfullband)  );
						if (tabla_dpx[i].isfullband === true	)
						{						 
							v_temp_dpxlowstartcustom=tabla_dpx[i].dpxlowstart + ' MHz';
							v_temp_dpxlowstartcustomclass='';
							mindpxstartLOW=tabla_dpx[i].dpxlowstart;
						}
						if (tabla_dpx[i].isfullband == 'show'	)
						{						 
							v_temp_dpxlowstartcustom=tabla_dpx[i].dpxlowstartcustom + ' MHz';
							v_temp_dpxlowstartcustomclass='';
							mindpxstartLOW=tabla_dpx[i].dpxlowstartcustom;
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

						v_temp_dpxlowstopcustom='';
						v_temp_dpxlowstopcustomomclass='colorfondonaranja';
						if (tabla_dpx[i].isfullband === true	)
						{						 
							v_temp_dpxlowstopcustom=tabla_dpx[i].dpxlowstop + ' MHz';
							v_temp_dpxlowstopcustomomclass='';
							mindpxstopLOW=tabla_dpx[i].dpxlowstop ;
						}

						if (tabla_dpx[i].isfullband == 'show'	)
						{						 
							v_temp_dpxlowstopcustom=tabla_dpx[i].dpxlowstopcustom + ' MHz';
							v_temp_dpxlowstopcustomomclass='';
							mindpxstopLOW=tabla_dpx[i].dpxlowstopcustom ;
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

						v_temp_dpxhighstartcustom='';
						v_temp_dpxhighstartcustomclass='colorfondonaranja';
						if (tabla_dpx[i].isfullband === true	)
						{						 
							v_temp_dpxhighstartcustom=tabla_dpx[i].dpxhighstart + ' MHz';
							v_temp_dpxhighstartcustomclass='';
							mindpxstartHIGH=tabla_dpx[i].dpxhighstart;
						}
						if (tabla_dpx[i].isfullband == 'show'	)
						{						 
							v_temp_dpxhighstartcustom=tabla_dpx[i].dpxhighstartcustom + ' MHz';
							v_temp_dpxhighstartcustomclass='';
							mindpxstartHIGH=tabla_dpx[i].dpxhighstartcustom;
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

						v_temp_dpxhighstopcustom='';
					v_temp_dpxhighstopcustomclass='colorfondonaranja';
					if (tabla_dpx[i].isfullband === true	)
						{						 
							v_temp_dpxhighstopcustom=tabla_dpx[i].dpxhighstop + ' MHz';
							v_temp_dpxhighstopcustomclass='';
							mindpxstopHIGH=tabla_dpx[i].dpxhighstop;
						}
						if (tabla_dpx[i].isfullband =='show'	)
						{						 
							v_temp_dpxhighstopcustom=tabla_dpx[i].dpxhighstopcustom + ' MHz';
							v_temp_dpxhighstopcustomclass='';
							mindpxstopHIGH=tabla_dpx[i].dpxhighstopcustom;
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
					
					for( var immxx = 0; immxx < tabla_dpx[i].qband; immxx++) 
					{
						imm = tabla_dpx[i].idarray;
						htmlmejoradodpx += '<tr><th width="100px" scope="row"> '+tabla_dpx[i].Band+'   &nbsp;&nbsp; <a href="#" onclick="borrar_array_dpx('+imm+')" title="Delete the DPX"><i class="fas fa-times-circle"></i></a>   </th>';
					htmlmejoradodpx += '<td  width="150px"  contenteditable="true" class=" text-center '+v_temp_dpxlowstartcustomclass+'  id'+imm+'#dpxlowstartcustom'+'" id="id'+imm+'#dpxlowstartcustom" onkeypress="return soloNumeros(event)"  onblur="modif_table_arraydpx('+"'id"+imm+'#dpxlowstartcustom'+"'"+','+imm+')" >'+v_temp_dpxlowstartcustom+' </td>';
					htmlmejoradodpx +='	<td width="150px"   contenteditable="true" class=" text-center '+v_temp_dpxlowstopcustomomclass+'  id'+imm+'#dpxlowstopcustom'+'" id="id'+imm+'#dpxlowstopcustom" onkeypress="return soloNumeros(event)"  onblur="modif_table_arraydpx('+"'id"+imm+'#dpxlowstopcustom'+"'"+','+imm+')" >'+v_temp_dpxlowstopcustom+' </td>';
					htmlmejoradodpx += '<td  width="150px" contenteditable="true" class=" text-center '+v_temp_dpxhighstartcustomclass+'  id'+imm+'#dpxhighstartcustom'+'" id="id'+imm+'#dpxhighstartcustom" onkeypress="return soloNumeros(event)"  onblur="modif_table_arraydpx('+"'id"+imm+'#dpxhighstartcustom'+"'"+','+imm+')" >'+v_temp_dpxhighstartcustom+' </td>';
					htmlmejoradodpx +=	'<td width="150px"  contenteditable="true" class=" text-center '+v_temp_dpxhighstopcustomclass+'  id'+imm+'#dpxhighstopcustom'+'" id="id'+imm+'#dpxhighstopcustom" onkeypress="return soloNumeros(event)"  onblur="modif_table_arraydpx('+"'id"+imm+'#dpxhighstopcustom'+"'"+','+imm+')" >'+v_temp_dpxhighstopcustom+' </td>';
				
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
					/// $('#listadpx1').html(htmlmejoradodpx);
					//acamarcolistadpx1
					$('#templistadpx').val(v_temp_dpx);
	}

	function duplicamereg(idposaduplicar)
{
//console.log(tabla_gain_dlul[idposaduplicar].Band.substr(0,3));
			if  (tabla_gain_dlul[idposaduplicar].Band.substr(0,3) =="UHF")
			{

				
				tabla_dpx.push({	
															Band:"UHF FULL",												
															dpxlowstart: parseFloat(450),
															dpxlowstop:  parseFloat(512),
															dpxhighstart: parseFloat(450),
															dpxhighstop: parseFloat(512),
															dpxlowstartcustom:parseFloat(0),
															dpxlowstopcustom:   parseFloat(0),
															dpxhighstartcustom:parseFloat(0),
															dpxhighstopcustom: parseFloat(0),
															});
			}
			else
			{

				tabla_dpx.push({	
															Band:tabla_gain_dlul[idposaduplicar].Band,												
															dpxlowstart: parseFloat(tabla_gain_dlul[idposaduplicar].dpxlowstart),
															dpxlowstop:  parseFloat(tabla_gain_dlul[idposaduplicar].dpxlowstop),
															dpxhighstart: parseFloat(tabla_gain_dlul[idposaduplicar].dpxhighstart),
															dpxhighstop: parseFloat(tabla_gain_dlul[idposaduplicar].dpxhighstop),
															dpxlowstartcustom:parseFloat(0),
															dpxlowstopcustom:   parseFloat(0),
															dpxhighstartcustom:parseFloat(0),
															dpxhighstopcustom: parseFloat(0),
															});
			}


												 list_tabla_dpx_udul2dagen();
}
		
function modif_table_arraydpx (lacelda, valorcelda)
	{
		var losdatosaupatar = lacelda.split("#");

		///document.getElementsByClassName("id0#DL_Start")[0].innerHTML;
		var aaaobte = document.getElementsByClassName(lacelda)[0].innerHTML;
		var aaapbtelimpio = aaaobte.replace('MHz','');
		if ($.isNumeric( aaapbtelimpio) )
		{

		/*	console.log(	tabla_dpx[valorcelda].dpxhighstart);
			console.log(	tabla_dpx[valorcelda].dpxhighstop);

			console.log(	tabla_dpx[valorcelda].dpxlowstart);
			console.log(	tabla_dpx[valorcelda].dpxlowstop);*/
			
		
		
			if ( losdatosaupatar[1] =='dpxhighstartcustom' || losdatosaupatar[1] =='dpxhighstopcustom')
			{
				if ( parseFloat (tabla_dpx[valorcelda].dpxhighstart) <= parseFloat(aaapbtelimpio) && parseFloat (tabla_dpx[valorcelda].dpxhighstop) >= parseFloat(aaapbtelimpio) )
				{
					tabla_dpx[valorcelda][losdatosaupatar[1]]=aaapbtelimpio;
					tabla_dpx[valorcelda].isfullband = 'show';
				}
				else
				{
					alert('HIGH::out of range');
					///tabla_dpx[valorcelda][losdatosaupatar[1]]=aaapbtelimpio;
				}
			}
			if ( losdatosaupatar[1] =='dpxlowstartcustom' || losdatosaupatar[1] =='dpxlowstopcustom')
			{
	//			console.log('validando' + valorcelda);
		//		console.log( aaapbtelimpio);
		//		console.log(tabla_dpx[valorcelda].dpxlowstart);
				if ( parseFloat (tabla_dpx[valorcelda].dpxlowstart) <= parseFloat(aaapbtelimpio) && parseFloat (tabla_dpx[valorcelda].dpxlowstop) >= parseFloat(aaapbtelimpio) )
				{
					tabla_dpx[valorcelda][losdatosaupatar[1]]=aaapbtelimpio;
					tabla_dpx[valorcelda].isfullband = 'show';
					console.log('SI Entro');
				}
				else
				{
					alert('LOW::out of range');
					///tabla_dpx[valorcelda][losdatosaupatar[1]]=aaapbtelimpio;
				}
			}

			
		///	tabla_dpx[valorcelda][losdatosaupatar[1]]=aaapbtelimpio;	

		}
	//	console.log(aaaobte);
	//	console.log(valorcelda);
	//	console.log(losdatosaupatar[1]);

	
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
			
			if ( losdatosaupatar[1] =='DL_Start' || losdatosaupatar[1] =='DL_Stop')
			{
				if ( parseFloat (tabla_gain_dlul[valorcelda].hiddengainudstart) <= parseFloat(aaapbtelimpio) && parseFloat (tabla_gain_dlul[valorcelda].hiddengainudstop) >= parseFloat(aaapbtelimpio) )
				{
					tabla_gain_dlul[valorcelda][losdatosaupatar[1]]=aaapbtelimpio;
				}
				else
				{
					alert('DL::out of range');
					tabla_gain_dlul[valorcelda][losdatosaupatar[1]]=aaapbtelimpio;
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
					tabla_gain_dlul[valorcelda][losdatosaupatar[1]]=aaapbtelimpio;	
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

	function tabla_gain_udul2dagen()
	{
		var jname ="";
		var v_templistchannel="";
		var esUHFVHF=0;
		var htmlmejorado='	<table class="table table-striped table-bordered table-sm"><thead >    <tr ><th class="table-dark text-center" scope="col">#</th> <th class="table-primary text-center" colspan=4 scope="col">DOWNLINK </th><th  class="table-info text-center" colspan=4 scope="col">UPLINK</th> </tr>';
		htmlmejorado += '<tr> <th width="80px"  class="table-dark text-center"  style="width: 80px">Band</th> <th  class="table-primary text-center" >Start </th> <th  class="table-primary text-center" >Stop </th><th  class="table-primary text-center" >Gain </th><th  class="table-primary text-center" >Max Pwr</th> <th  class="table-info text-center">Start </th><th  class="table-info text-center">Stop </th><th  class="table-info text-center">Gain </th> <th  class="table-info text-center">Max Pwr</th>  </thead> <tbody>';
		
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
		//	console.log(tabla_gain_dlul[0]);
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
//console.log('a'+ tabla_gain_dlul[i].Band.indexOf('700') );
//console.log('b'+ tabla_gain_dlul[i].Band.indexOf('800'));
			if (tabla_gain_dlul[i].Band.indexOf('700') >=0 || tabla_gain_dlul[i].Band.indexOf('800')>=0)	
			{
				htmlmejorado += '<tr><th width="80px" scope="row">'+tabla_gain_dlul[i].Band+'</th>	<td  width="80px" class=" text-center  id'+i+'#DL_Start'+'" id="id'+i+'#DL_Start" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#DL_Start'+"'"+','+i+')" >'+tabla_gain_dlul[i].hiddengainudstart+' </td>	<td width="80px" class=" text-center  id'+i+'#DL_Stop'+'" id="id'+i+'#DL_Stop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#DL_Stop'+"'"+','+i+')" >'+tabla_gain_dlul[i].hiddengainudstop+' </td><td class=" text-center" >'+tabla_gain_dlul[i].noteditDL_gain+' dB </td><td class=" text-center" >'+tabla_gain_dlul[i].noteditDL_maxpwr+' dBm</td>';
				htmlmejorado += '<td  width="80px" class=" text-center  id'+i+'#UL_Start'+'" id="id'+i+'#UL_Start" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#UL_Start'+"'"+','+i+')"  >'+tabla_gain_dlul[i].hiddengainulstart+' </td><td width="80px" class=" text-center  id'+i+'#UL_Stop'+'" id="id'+i+'#UL_Stop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#UL_Stop'+"'"+','+i+')" >'+tabla_gain_dlul[i].hiddengainulstop+' </td><td  class=" text-center">'+tabla_gain_dlul[i].noteditUL_gain+' dB</td>';
				htmlmejorado += ' <td width="80px" class=" text-center" >'+tabla_gain_dlul[i].noteditUL_maxpwr+' dBm </td> ';
			
			}
			else
			{
				if (esUHFVHF==0 ||esUHFVHF==2)
				{
 					//console.log('esUHFVHF:'+esUHFVHF+ '--buscamos:' +tiene2UHF);
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

				htmlmejorado += '<tr><th width="80px" scope="row">'+nombandper +'</th>	<td  width="80px" class=" text-center '+v_temp_DL_Startclass+' id'+i+'#DL_Start'+'" id="id'+i+'#DL_Start" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#DL_Start'+"'"+','+i+')"  contenteditable="true">'+v_temp_DL_Start+' </td>	<td width="80px" class=" text-center '+v_temp_DL_Stopclass+' id'+i+'#DL_Stop'+'" id="id'+i+'#DL_Stop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#DL_Stop'+"'"+','+i+')"  contenteditable="true">'+v_temp_DL_Stop+' </td><td class=" text-center" >'+tabla_gain_dlul[i].noteditDL_gain+' dB </td><td class=" text-center" >'+tabla_gain_dlul[i].noteditDL_maxpwr+' dBm</td>';
				htmlmejorado += '<td  width="80px" class=" text-center '+v_temp_Startclass+' id'+i+'#UL_Start'+'" id="id'+i+'#UL_Start" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#UL_Start'+"'"+','+i+')"  contenteditable="true">'+v_temp_Start+' </td><td width="80px" class=" text-center '+v_temp_UL_Stopclass+' id'+i+'#UL_Stop'+'" id="id'+i+'#UL_Stop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#UL_Stop'+"'"+','+i+')"  contenteditable="true">'+v_temp_UL_Stop+' </td><td  class=" text-center">'+tabla_gain_dlul[i].noteditUL_gain+' dB</td>';
				htmlmejorado += ' <td  class=" text-center" > '+tabla_gain_dlul[i].noteditUL_maxpwr+' dBm </td> ';
				}
			}
		
			/// Validamos UHF VHF
					if (tabla_gain_dlul[i].Band.indexOf('UHF')>=0)
						{
							esUHFVHF=esUHFVHF+1;	
						}
						if (tabla_gain_dlul[i].Band.indexOf('VHF')>=0)
						{
						//	esUHFVHF=1;	
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
										html += '<td width="80px" contenteditable="true" id="id'+i+'#'+j+'" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#'+j+"'"+','+i+')" class=" colorfondonaranja id'+i+'#'+j+'"> -missing info -</td>';	  
									}
									else
									{
										html += '<td width="80px" contenteditable="true" id="id'+i+'#'+j+'" onkeypress="return soloNumeros(event)" class="id'+i+'#'+j+'" onblur="modif_table_array('+"'id"+i+'#'+j+"'"+','+i+')">  ' + tabla_gain_dlul[i][j]  +' MHz</td>';	  
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
			//	 console.log(v_templistchannel);
				 //	$('#listagainuldl').html(html+'<br><br>'+htmlmejorado);
					 $('#listagainuldl').html(htmlmejorado);
					 $('#listagainuldl1').html(htmlmejorado);
					$('#templistagainuldl').val(v_templistchannel);
				
		
	}

	function tabla_gain_udul2dagen_solomuestra()
	{
		var jname ="";
		var v_templistchannel="";
		var esUHFVHF=0;
		var htmlmejorado='	<table class="table table-striped table-bordered table-sm"><thead >    <tr ><th class="table-dark text-center" scope="col">#</th> <th class="table-primary text-center" colspan=4 scope="col">DOWNLINK </th><th  class="table-info text-center" colspan=4 scope="col">UPLINK</th> </tr>';
		htmlmejorado += '<tr> <th width="80px"  class="table-dark text-center"  style="width: 80px">Band</th> <th  class="table-primary text-center" >Start </th> <th  class="table-primary text-center" >Stop </th><th  class="table-primary text-center" >Gain </th><th  class="table-primary text-center" >Max Pwr</th> <th  class="table-info text-center">Start </th><th  class="table-info text-center">Stop </th><th  class="table-info text-center">Gain </th> <th  class="table-info text-center">Max Pwr</th>  </thead> <tbody>';
		
		/// Buscamos 2 UHF
		var tiene2UHF =0;
		for( var im = 0; im < tabla_gain_dlul_onlyshow.length; im++) 
		{	
				if (tabla_gain_dlul_onlyshow[im].Band.indexOf('UHF')>=0)
				{
					tiene2UHF =tiene2UHF + 1;
				}
		}

		for( var i = 0; i < tabla_gain_dlul_onlyshow.length; i++) 
		{
		//	console.log(tabla_gain_dlul[0]);
			var v_temp_DL_Start='';
			var v_temp_DL_Startclass='';

			if (tabla_gain_dlul_onlyshow[i].DL_Start==0)
			{
				v_temp_DL_Start='';
				v_temp_DL_Startclass='colorfondonaranja';
			}
			else
			{
				v_temp_DL_Start=tabla_gain_dlul_onlyshow[i].DL_Start+ ' MHz';
				v_temp_DL_Startclass='';
			}

			var v_temp_DL_Stopclass= ''
			var v_temp_DL_Stop='';
			if (tabla_gain_dlul_onlyshow[i].DL_Stop==0)
			{
				v_temp_DL_Stop='';
				v_temp_DL_Stopclass='colorfondonaranja';
			}
			else
			{
				v_temp_DL_Stop=tabla_gain_dlul_onlyshow[i].DL_Stop + ' MHz';
				v_temp_DL_Stopclass='';
			}

			var v_temp_UL_Stopclass= ''
			var v_temp_UL_Stop='';
			if (tabla_gain_dlul_onlyshow[i].UL_Stop==0)
			{
				v_temp_UL_Stop='';
				v_temp_UL_Stopclass='colorfondonaranja';
			}
			else
			{
				v_temp_UL_Stop=tabla_gain_dlul_onlyshow[i].UL_Stop + ' MHz';
				v_temp_UL_Stopclass='';
			}

			var v_temp_Startclass= ''
			var v_temp_Start='';
			if (tabla_gain_dlul_onlyshow[i].UL_Start==0)
			{
				v_temp_Start='';
				v_temp_Startclass='colorfondonaranja';
			}
			else
			{
				v_temp_Start=tabla_gain_dlul_onlyshow[i].UL_Start + ' MHz';
				v_temp_Startclass='';
			}
//console.log('a'+ tabla_gain_dlul[i].Band.indexOf('700') );
//console.log('b'+ tabla_gain_dlul[i].Band.indexOf('800'));
//console.log('66aver'+ tabla_gain_dlul_onlyshow[i].noteditDL_maxpwr);
			if (tabla_gain_dlul_onlyshow[i].Band.indexOf('700') >=0 || tabla_gain_dlul_onlyshow[i].Band.indexOf('800')>=0)	
			{
				if(isNaN(tabla_gain_dlul[i].noteditDL_maxpwr))
				{
					htmlmejorado += '<tr><th width="80px" scope="row">'+tabla_gain_dlul_onlyshow[i].Band+'</th>	<td  width="80px" class=" text-center  id'+i+'#DL_Start'+'" id="id'+i+'#DL_Start" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#DL_Start'+"'"+','+i+')" >'+tabla_gain_dlul[i].hiddengainudstart+' MHz </td>	<td width="80px" class=" text-center  id'+i+'#DL_Stop'+'" id="id'+i+'#DL_Stop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#DL_Stop'+"'"+','+i+')" >'+tabla_gain_dlul_onlyshow[i].hiddengainudstop+' MHz </td><td class=" text-center" >'+tabla_gain_dlul_onlyshow[i].noteditDL_gain+' dB </td><td class=" text-center" >Missing Inf.</td>';
				}
				else
				{
					htmlmejorado += '<tr><th width="80px" scope="row">'+tabla_gain_dlul_onlyshow[i].Band+'</th>	<td  width="80px" class=" text-center  id'+i+'#DL_Start'+'" id="id'+i+'#DL_Start" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#DL_Start'+"'"+','+i+')" >'+tabla_gain_dlul[i].hiddengainudstart+' </td>	<td width="80px" class=" text-center  id'+i+'#DL_Stop'+'" id="id'+i+'#DL_Stop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#DL_Stop'+"'"+','+i+')" >'+tabla_gain_dlul_onlyshow[i].hiddengainudstop+' </td><td class=" text-center" >'+tabla_gain_dlul_onlyshow[i].noteditDL_gain+' dB </td><td class=" text-center" >'+tabla_gain_dlul[i].noteditDL_maxpwr+' dBm</td>';
				}
				
				htmlmejorado += '<td  width="80px" class=" text-center  id'+i+'#UL_Start'+'" id="id'+i+'#UL_Start" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#UL_Start'+"'"+','+i+')"  >'+tabla_gain_dlul[i].hiddengainulstart+' </td><td width="80px" class=" text-center  id'+i+'#UL_Stop'+'" id="id'+i+'#UL_Stop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#UL_Stop'+"'"+','+i+')" >'+tabla_gain_dlul_onlyshow[i].hiddengainulstop+' </td><td  class=" text-center">'+tabla_gain_dlul_onlyshow[i].noteditUL_gain+' dB</td>';
			//	console.log('bbbb'+tabla_gain_dlul_onlyshow[i].noteditUL_maxpwr+'a ver:::'+isNaN(tabla_gain_dlul_onlyshow[i].noteditUL_maxpwr));
				if(isNaN(tabla_gain_dlul_onlyshow[i].noteditUL_maxpwr))
				{
					htmlmejorado += ' <td width="80px" class=" text-center" >missing information </td> ';
				}
				else
				{
					htmlmejorado += ' <td width="80px" class=" text-center" >'+tabla_gain_dlul_onlyshow[i].noteditUL_maxpwr+' dBm </td> ';
				}
				
			
			}
			else
			{
				if (esUHFVHF==0 ||esUHFVHF==2)
				{
 					//console.log('esUHFVHF:'+esUHFVHF+ '--buscamos:' +tiene2UHF);
					var nombandper='';
					if (tiene2UHF==2)
					 {
						nombandper = 'UHF FULL'; 
						///cargar en el array.. lo datos..UHF FULL
			         }
			 		 else
					 {
						nombandper =tabla_gain_dlul_onlyshow[i].Band;             
				 	 }
			//		  console.log('77aver'+ tabla_gain_dlul[i].noteditDL_maxpwr);
					  if(isNaN(tabla_gain_dlul_onlyshow[i].noteditDL_maxpwr))
					  {
						htmlmejorado += '<tr><th width="80px" scope="row">'+nombandper +'</th>	<td  width="80px" class=" text-center '+v_temp_DL_Startclass+' id'+i+'#DL_Start'+'" id="id'+i+'#DL_Start" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#DL_Start'+"'"+','+i+')"  contenteditable="true">'+v_temp_DL_Start+' </td>	<td width="80px" class=" text-center '+v_temp_DL_Stopclass+' id'+i+'#DL_Stop'+'" id="id'+i+'#DL_Stop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#DL_Stop'+"'"+','+i+')"  contenteditable="true">'+v_temp_DL_Stop+' </td><td class=" text-center" >'+tabla_gain_dlul_onlyshow[i].noteditDL_gain+' dB </td><td class=" text-center" >Missing Inf.</td>';
					  }
					  else
					  {
						htmlmejorado += '<tr><th width="80px" scope="row">'+nombandper +'</th>	<td  width="80px" class=" text-center '+v_temp_DL_Startclass+' id'+i+'#DL_Start'+'" id="id'+i+'#DL_Start" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#DL_Start'+"'"+','+i+')"  contenteditable="true">'+v_temp_DL_Start+' </td>	<td width="80px" class=" text-center '+v_temp_DL_Stopclass+' id'+i+'#DL_Stop'+'" id="id'+i+'#DL_Stop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#DL_Stop'+"'"+','+i+')"  contenteditable="true">'+v_temp_DL_Stop+' </td><td class=" text-center" >'+tabla_gain_dlul_onlyshow[i].noteditDL_gain+' dB </td><td class=" text-center" >'+tabla_gain_dlul_onlyshow[i].noteditDL_maxpwr+' dBm</td>';
					  }
						
						htmlmejorado += '<td  width="80px" class=" text-center '+v_temp_Startclass+' id'+i+'#UL_Start'+'" id="id'+i+'#UL_Start" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#UL_Start'+"'"+','+i+')"  contenteditable="true">'+v_temp_Start+' </td><td width="80px" class=" text-center '+v_temp_UL_Stopclass+' id'+i+'#UL_Stop'+'" id="id'+i+'#UL_Stop" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#UL_Stop'+"'"+','+i+')"  contenteditable="true">'+v_temp_UL_Stop+' </td><td  class=" text-center">'+tabla_gain_dlul_onlyshow[i].noteditUL_gain+' dB</td>';
				//	console.log('aaaaaaaaaaaaaaaaa'+tabla_gain_dlul[i].noteditUL_maxpwr+'a ver:::'+isNaN(tabla_gain_dlul[i].noteditUL_maxpwr));
					if(isNaN(tabla_gain_dlul_onlyshow[i].noteditUL_maxpwr))
					{
						htmlmejorado += ' <td  class=" text-center" > missing information </td> ';
					}
					else
					{
						htmlmejorado += ' <td  class=" text-center" >'+tabla_gain_dlul_onlyshow[i].noteditUL_maxpwr+' dBm </td> ';
					}
				
				}
			}
		
			/// Validamos UHF VHF
					if (tabla_gain_dlul_onlyshow[i].Band.indexOf('UHF')>=0)
						{
							esUHFVHF=esUHFVHF+1;	
						}
						if (tabla_gain_dlul_onlyshow[i].Band.indexOf('VHF')>=0)
						{
						//	esUHFVHF=1;	
						}
		}
		htmlmejorado += ' </tbody></table><P style="color:rgba(250, 5, 5)";>* <b>The cell that contains this color indicates missing information.</b></P> '
	
				var html = '<table class="table  table-striped table-sm ">';
				 html += '<tr>';
				 var cantcabez = tabla_gain_dlul_onlyshow[0];

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
				 for( var i = 0; i < tabla_gain_dlul_onlyshow.length; i++) {
				  html += '<tr>';
				  
				  if (v_templistchannel != '')
				  {
					v_templistchannel = v_templistchannel + "#";  
				  }
				  
				  for( var j in tabla_gain_dlul_onlyshow[i] ) {
					 
					 if ( 'UNKNOW' == tabla_gain_dlul_onlyshow[i][j] )
					 {
						 html += '<td>' + tabla_gain_dlul_onlyshow[i][j]  +' </td>';	   
					 }
				     else
					 {
					  /// html += '<td>' + tabla_gain_dlul_onlyshow[i][j]  +' MHz</td>';	   
					   if (j =='Band')
						{
							html += '<td>' + tabla_gain_dlul_onlyshow[i][j]  +' </td>';	  
						}
						else
						{
							if (!j.indexOf('hidden'))
							{
							//	html += '<td contenteditable="true"> sss ' + tabla_gain_dlul_onlyshow[i][j]  +' MHz</td>';	  
							}
							else
							{
								if (j.indexOf('notedit'))
								{
									if (tabla_gain_dlul_onlyshow[i][j]==0 || (isNaN(tabla_gain_dlul_onlyshow[i][j])))
									{
										html += '<td width="80px" contenteditable="true" id="id'+i+'#'+j+'" onkeypress="return soloNumeros(event)"  onblur="modif_table_array('+"'id"+i+'#'+j+"'"+','+i+')" class=" colorfondonaranja id'+i+'#'+j+'"> -missing info -</td>';	  
									}
									else
									{
										html += '<td width="80px" contenteditable="true" id="id'+i+'#'+j+'" onkeypress="return soloNumeros(event)" class="id'+i+'#'+j+'" onblur="modif_table_array('+"'id"+i+'#'+j+"'"+','+i+')">  ' + tabla_gain_dlul_onlyshow[i][j]  +' MHz</td>';	  
									}
								
								}
								else
								{
									html += '<td > ' + tabla_gain_dlul_onlyshow[i][j]  +' </td>';	  
								}
							
							}
							
						}
					 }	 
						
						v_templistchannel = v_templistchannel  + tabla_gain_dlul_onlyshow[i][j] + "|"
					
					
				  }
				  html += '<td>  <a href="#" onclick="borrar_array_uldl('+i+')"> <i class="fas fa-trash-alt"></i> Del</a> </td>';	  
				  html += '</tr>';
				 }
				 html += '</table>';
				 //no usar la variable html.. es html viejo
				 v_templistchannel = v_templistchannel + "#";  
			//	 console.log(v_templistchannel);
				 //	$('#listagainuldl').html(html+'<br><br>'+htmlmejorado);
					 $('#listagainuldl').html(htmlmejorado);
					 $('#listagainuldl1').html(htmlmejorado);
					$('#templistagainuldl').val(v_templistchannel);
				
		
	}


	function soloNumeros(e){
	var key = window.Event ? e.which : e.keyCode
	return (key >= 48 && key <= 57 || key==46  )
}

function Call_printcovers(vpara_ciu, vcant,vwo,vnomcli)
	{
	//			console.log('si' + vpara_ciu);
				var ipservidorapache= '<?php echo $ipservidorapache; ?>';	
		eModal.iframe('https://'+ipservidorapache+'/printoscovers.php?vciu='+vpara_ciu+'&cc='+vcant+'&vwo='+vwo+'&vnomc='+vnomcli,'Print SO Covers');
	 
							
	}	

	function listattachfile(idt, nroso, idp)
	{
		var ipservidorapache= '<?php echo $ipservidorapache; ?>';	
		eModal.iframe('https://'+ipservidorapache+'/showattachfile.php?vso='+nroso,'View attachments : ' + nroso);
	 	
	}

	function addfiletoso(lasemillita, vidord)
	{
		eModal.iframe('attachfileprojectsoaddmore.php?idt='+lasemillita+'&idord='+vidord,'Attach files to SO	  ');
		$('#generalinfopo').html('');
		/*setTimeout(function(){
					show_po(vidord, 1);
				 	console.log("Refresh Web");
				}, 15000);
				*/

	}

	function add_dpxdiv()
	{
		$("#divadddpxmm").removeClass('d-none');
	}

	function addonedpxtolist()
	{

		Number.prototype.between = function(a, b, inclusive) {
			var min = Math.min(a, b),
				max = Math.max(a, b);

			return inclusive ? this >= min && this <= max : this > min && this < max;
			}



		/// Validamossss
		if (	$("#txtnewbanddpx").val() =='')
		{
			alert('you must select a DPX band');
		}
		else
		{
			var res = $("#txtnewbanddpx").val();
			var splitbandselect = res.split("#");
			//////controlamos las bandas
			var todoscompletos = 0;
			if ($("#txtnewdpxlowstart").val() ==0)
			{
				todoscompletos=1;
			}
			if ($("#txtnewdpxlowstop").val() ==0)
			{
				todoscompletos=1;
			}
			if ($("#txtnewdpxhighstart").val() ==0)
			{
				todoscompletos=1;
			}
			if ($("#txtnewdpxhighstop").val() ==0)
			{
				todoscompletos=1;
			}
			
			if(	todoscompletos==0)
			{
				var elvalor_dpxlowstart = parseFloat($("#txtnewdpxlowstart").val());
				var elvalor_dpxlowstop = parseFloat($("#txtnewdpxlowstop").val());
				//console.log(elvalor_dpxlowstart.between( parseFloat (splitbandselect[1]) , parseFloat (splitbandselect[2]),true) );

				if ( (elvalor_dpxlowstart.between( parseFloat (splitbandselect[1]) , parseFloat (splitbandselect[2]),true)) && (elvalor_dpxlowstop.between( parseFloat (splitbandselect[1]) , parseFloat (splitbandselect[2]),true))  )
				{
					var elvalor_dpxhighstart = parseFloat($("#txtnewdpxhighstart").val());
					var elvalor_dpxhighstop = parseFloat($("#txtnewdpxhighstop").val());
					if ( (elvalor_dpxhighstart.between( parseFloat (splitbandselect[3]) , parseFloat (splitbandselect[4]),true)) && (elvalor_dpxhighstop.between( parseFloat (splitbandselect[3]) , parseFloat (splitbandselect[4]),true))  )
						{
							vindexarray = vindexarray + 1;
							tabla_dpx.push({	
								Band:splitbandselect[5],												
								dpxlowstart: parseFloat(splitbandselect[1]),
								dpxlowstop:  parseFloat(splitbandselect[2]),
								dpxhighstart: parseFloat(splitbandselect[3]),
								dpxhighstop: parseFloat(splitbandselect[4]),
								dpxlowstartcustom:parseFloat(	$("#txtnewdpxlowstart").val()),
								dpxlowstopcustom:   parseFloat($("#txtnewdpxlowstop").val()),
								dpxhighstartcustom:parseFloat($("#txtnewdpxhighstart").val()),
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
					else
					{
						alert('HIGH :Out of range');
					}
				}
				else
				{
				//	alert('LOW :Out of range');
				vindexarray = vindexarray + 1;
				tabla_dpx.push({	
								Band:splitbandselect[5],												
								dpxlowstart: parseFloat(splitbandselect[1]),
								dpxlowstop:  parseFloat(splitbandselect[2]),
								dpxhighstart: parseFloat(splitbandselect[3]),
								dpxhighstop: parseFloat(splitbandselect[4]),
								dpxlowstartcustom:parseFloat(	$("#txtnewdpxlowstart").val()),
								dpxlowstopcustom:   parseFloat($("#txtnewdpxlowstop").val()),
								dpxhighstartcustom:parseFloat($("#txtnewdpxhighstart").val()),
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


			

			}
			else
			{
				alert('you must enter the values ​​for the DPX');
			}

		}
		 

	


										

	}


	function  createtk()
 {
	// alert(idlog_view2);
	var idlog_view2=0;

		/*	$.ajax
			({ 
				url: 'listcategoryxtkajax.php',			
				type: 'post',
				async:true,
                cache:false,
				success: function(data)
				{
					var datax = JSON.parse(data)
					console.log(datax);
					$.each(data, function(index) {
						console.log(data[index].namecategory);
						
					});
        		
				}
			});
*/

//message: " <div class='form-group'>Specify SO:<input class='form-control form-control-sm' type='text' name='amf' id='amf'><br> Specify PN: </div>",	
	 
	 var userregistred = <?php echo "'".$_SESSION["b"]."'";?>;
	 var options = {     
	 message: " <div class='form-group'>SO: <textarea id='amf' name='amf' cols='100' rows='2' class='form-control form-control-sm' > </textarea></div> CIU:  ",		         		         
	 title: 'Tech Support FAS',
     size: eModal.size.lg,
     subtitle: '- Open an error ticket: SO-WO Missing: '        
    };
	
		/*eModal.prompt(options)
      .then(callback, callbackCancel);*/
	  
	     return eModal
                .prompt(options)
                .then(
                    function (input) {
					console.log(input);
				///	toastr["info"]("Sending information...", "");
toastr["info"]("Generating support ticket.<br><b> WAIT</b> for the save confirmation.", "");						
					$.ajax({
				url: 'ajaxinsert_supportit.php', 				
				data: "idruninfodb="+idlog_view2+'&v_issue='+input+'-Ref:'+idlog_view2+'&vuser='+userregistred+'&tp='+$('#amf').val()+'&tp1='+$('#amf').val()+'&keyd='+idlog_view2,					
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


 $('#txtlistciusup').select2({
 ajax: {
    url: "ajax_list_snbyupgrade.php",
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
  placeholder: 'Search SN',
  minimumInputLength: 1 ,
  templateResult: formatRepo,
  templateSelection: formatRepoSelection
});

            
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


</script>

</html>


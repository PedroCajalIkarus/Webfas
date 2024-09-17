<?php
  error_reporting(0);
  include("db_conect.php");
  header('Content-Type: application/json');
 
	/*
		url: 'ajax_update_sn_fromwotoso.php',
												data: "pp_idwo="+pp_idwo+'&pp_sn='+pp_sn+'&pp_idso='+pp_idso+'&pp_so='+pp_so,	
												*/
		$pp_idwo = $_REQUEST['pp_idwo'];   
		$pp_sn = trim($_REQUEST['pp_sn']);   
		$pp_idso = $_REQUEST['pp_idso'];   
		$pp_so = $_REQUEST['pp_so'];   
        $pp_wo= $_REQUEST['pp_wo'];   
		$pp_posap= $_REQUEST['pp_posap'];   
		$pp_idnroserie =  $_REQUEST['pp_idnroserie'];   
		 $nameapproved = $_SESSION["b"];	
		 $vuserfas = $_SESSION["b"];
						
		$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
		$vaccionweb="update po so sn";
	
		$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->beginTransaction();
	
		
			 
			////controlamos las cantidades de orders y orders_sn

			$sqlcontroqty="select idorders from orders where idorders =".$pp_idso." and quantity > (select count (wo_serialnumber) from orders_sn where idorders =".$pp_idso." and idnroserie>0)";
			$sql_busca_qty = $connect->prepare($sqlcontroqty);
			$sql_busca_qty->execute();
					$tienelugar ="N";
			$resulrepairqty = $sql_busca_qty->fetchAll();
			foreach ($resulrepairqty as $rowbusca2qty) 
			{
				$tienelugar ="Y";
			}

			if ($tienelugar =="Y")
			{ 
				
				try {

			
								 
										///-------si no existe esa order y idnroserie..busco el template.. con el max idrev y lo inserto
							 			$sql = $connect->prepare("insert into orders_sn SELECT idorders, idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, idrev, (select max(idnroserie)+1 FROM orders_sn where idorders   =:v_idorders ), so_soft_external, :v_sn, idruninfo, ".$pp_posap.", pwrsupplytype, rcgfbwa, moden_dig, date_approved, descripcion, ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, nameapproved, notes, reqresources, typeregister, processday, processfasserver, so_original, :v_nrowo FROM orders_sn  where idorders   = :v_idorders	and idrev in (select max(idrev) FROM orders_sn where idorders   =:v_idorders2	 ) order by idnroserie desc limit 1;");
											//	$sql->bindParam(':vidsn',$pp_idnroserie);
												$sql->bindParam(':v_sn', trim($pp_sn));
												$sql->bindParam(':v_nrowo', $pp_wo);
												$sql->bindParam(':v_idorders', $pp_idso);
												$sql->bindParam(':v_idorders2', $pp_idso);
												
												 $sql->execute();
												 
											
											$vtextaudit="insert into orders_sn SELECT idorders, idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, idrev, :vidsn, so_soft_external, :v_sn, idruninfo, ponumber, pwrsupplytype, rcgfbwa, moden_dig, date_approved, descripcion, ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, nameapproved, notes, reqresources, typeregister, processday, processfasserver, so_original, :v_nrowo FROM orders_sn  where idorders   = :v_idorders	and idrev in (select max(idrev) FROM orders_sn where idorders   =:v_idorders	 ) order by idnroserie desc limit 1;";	  
											
											$vtextaudit=$vtextaudit."!!v_sn:".$pp_sn;
												$vtextaudit=$vtextaudit."!!v_idorders:".$pp_idsoo;
												$vtextaudit=$vtextaudit."!!vidsn:".$pp_idnroserie;
												$vtextaudit=$vtextaudit."!!v_nrowo:".$pp_wo;
											
											
										  $sql = $connect->prepare("insert into orders_sn_specs SELECT idorders, idrev, idch, (select max(idnroserie) FROM orders_sn where idorders   =:v_idorders ), typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, notes, idband, ulgain, dlgain, ulmaxpwr, dlmaxpwr FROM orders_sn_specs where idorders   = :v_idorders and idnroserie = 0 and idrev in (select max(idrev) FROM orders_sn_specs where idorders   = :v_idorders2 );");
												//$sql->bindParam(':vidsn', $pp_idnroserie);
												$sql->bindParam(':v_idorders', $pp_idso);
													$sql->bindParam(':v_idorders2', $pp_idso);
												
												
												  $sql->execute();
									 
								
								 	$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
						
							
							
								$vdescripaudit="orders_sn Update SN ".$pp_sn." proceso SO ".$pp_idso." tracking - user:".$vuserfas;		
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();	
					
							
						
						
							  $id_sn_autogenerado= $id_sn_autogenerado+1;
						//	echo "PASOOOOOOOOOOOOOOOOOOOO POR CALL";
					///		echo "update orders_sn set so_associed = (select distinct so_soft_external from orders_sn where idorders =".$pp_idso." and  wo_serialnumber ='".$pp_sn."' ) where so_soft_external = :v_woassocied and wo_serialnumber = '".$pp_sn."' ";
							$sql = $connect->prepare("update orders_sn set so_associed = (select distinct so_soft_external from orders_sn where idorders =:vvidlog and  wo_serialnumber = :v_sn ) where so_soft_external = :v_woassocied and wo_serialnumber = :v_sn");
							$sql->bindParam(':vvidlog', $pp_idso);
							$sql->bindParam(':v_sn', $pp_sn);
							$sql->bindParam(':v_woassocied', $pp_wo);
							  $sql->execute();
					 
							  $sql = $connect->prepare("update orders_sn set idorders_nxt_trk = (select distinct idorders from orders_sn where idorders =:vvidlog and  wo_serialnumber = :v_sn ) where so_soft_external = :v_woassocied and wo_serialnumber = :v_sn");
							  $sql->bindParam(':vvidlog', $pp_idso);
							  $sql->bindParam(':v_sn', $pp_sn);
							  $sql->bindParam(':v_woassocied', $pp_wo);
								$sql->execute();
					 
								
								$sql = $connect->prepare("update orders_sn set idnroserie_nxt_trk = (select distinct idnroserie from orders_sn where idorders =:vvidlog and  wo_serialnumber = :v_sn ) where so_soft_external = :v_woassocied and wo_serialnumber = :v_sn");
								$sql->bindParam(':vvidlog', $pp_idso);
								$sql->bindParam(':v_sn', $pp_sn);
								$sql->bindParam(':v_woassocied', $pp_wo);
								  $sql->execute();
						 
							 
				
				  /////**************************************************** 

				  // Insertamos Estado 
				   $sql2 = $connect->prepare("update orders_sn set processfasserver = false,  typeregister= 'SO'  WHERE idorders = :vvidlog  ");
				  $sql2->bindParam(':vvidlog', $pp_idso);			  
				  
			  	  $sql2->execute();
			 	  
				  $sql2 = $connect->prepare("update orders set processfasserver = false,  typeregister= 'SO'   WHERE idorders = :vvidlog  ");
				  $sql2->bindParam(':vvidlog', $pp_idso);
				   $sql2->execute();

				   $sqlm="SELECT orders_sn.idorders,  orders_sn.idnroserie 
					FROM orders_sn
					left join orders_sn_specs
					on  orders_sn_specs.idorders	=	orders_sn.idorders	and
						orders_sn_specs.idnroserie	=	orders_sn.idnroserie
					where orders_sn.idorders = ".$pp_idso." and orders_sn_specs.idnroserie is null";
				 //   echo  $sqlm;
			
						$sql_busca_siexiste = $connect->prepare($sqlm);
						$sql_busca_siexiste->execute();
						$exite_idnube = "N";
						$resulrepair = $sql_busca_siexiste->fetchAll();
						foreach ($resulrepair as $rowbusca2) 
						{
				  //          echo "<br>*->".$rowbusca2[0]."*->".$rowbusca2[1]."<br>";      
			
							$sqlupdar=" insert into orders_sn_specs 
							SELECT idorders, idrev, idch,  ".$rowbusca2[1].", typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, notes, idband, ulgain, dlgain, ulmaxpwr, dlmaxpwr
							FROM public.orders_sn_specs
							where idorders =  ".$pp_idso." and idnroserie= 0";
				   
					  //      echo "<br>".$sqlupdar;
							$sqlmma = $connect->prepare( $sqlupdar);
						   $sqlmma->execute();
						}


				   ///a_solutions_orders_attributes_sn_fromSO
				   $sql2a = $connect->prepare(" call a_solutions_orders_attributes_sn_fromSO(:v_so, :v_sn ) ");
				   $sql2a->bindParam(':v_so', $pp_idso);
				   $sql2a->bindParam(':v_sn', trim($pp_sn));
					$sql2a->execute();

			 

	 
					/// 'SNs Assign FAS_Server'
					$query_lista ="INSERT INTO orders_states(idorders, idstate, datestate)	VALUES (".$pp_idso.", 7, now());";
				   $connect->query($query_lista);
					 	$return_result_insert="ok"; 
										$msjerr= "";
			
					 $connect->commit();
					 
					 	
						/// INSERT para SERVIDOR DE peticions :: petitions_server
							$v_id_station = 	$_SESSION["k"]  	 ; //id station for user business
							$iduuff = 	$_SESSION["a"];
							$iduu = 22; /// usuario del servidor
							$v_id_station = 13; // station del servidor;

						 $parajson= '{"idorders":'.$pp_idso.'}';
							$sqlpetiti ="INSERT INTO public.fas_petitions_server(
						idpetition, petitiontype, iduserfrom, iduserto, idstationto, instance, date, status, exitstatus, parameters1, parameters2, parameters3, idexterna)
						VALUES ((select COALESCE(max(idpetition),0) + 1 from fas_petitions_server), 2, ".$iduuff.", ".$iduu.", ".$v_id_station.",'04F', now(), 0, null, '".$parajson."', null, null, null);";
	
			    	$connect->query($sqlpetiti);	


					$vuserfas = $_SESSION["b"];
					$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
					$vaccionweb="AssignSNtracking";
					$vdescripaudit="AssignSNtracking#".$_SERVER['SERVER_ADDR'] ;
					$vtextaudit="AssignSNtracking#".$pp_sn."#idso".$pp_idso;

					$sentenciach = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
					$sentenciach->bindParam(':userfas', $vuserfas);								
					$sentenciach->bindParam(':menuweb', $vmenufas);
					$sentenciach->bindParam(':actionweb', $vaccionweb);
					$sentenciach->bindParam(':descripaudit', $vdescripaudit);
					$sentenciach->bindParam(':textaudit', $vtextaudit);
					$sentenciach->execute();

					
					$return_result_insert="ok"; 	
					
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
			else
			 {
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ";
				
			}

	echo(json_encode(["result"=>$return_result_insert,"erromsj"=>$msjerr]));
?>
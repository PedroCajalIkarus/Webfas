<?php
// Desactivar toda notificación de error
error_reporting(0);

	include("db_conect.php"); 
	header('Content-Type: application/json');

  ///ajaxsectmodrabbit.php?ido='+idord+'&st='+haverab,
		  
	$v_ido= $_REQUEST['ido'];
	$v_st= $_REQUEST['st'];	

 
  $return_result_insert="";
  $tienerabbitcargado= 'N';
  //Buscamos si ya tiene txthavemodulerabbit RABBIT..
  $sqlmm = $connect->prepare("select distinct idorders	from orders_attributes where idorders = ".$v_ido." and idattribute_orders = 1  ");
  $sqlmm->execute();
  $resultadoma = $sqlmm->fetchAll();
   foreach ($resultadoma as $roddw) {
    $tienerabbitcargado= 'Y';
    
   }

   $sqlmmcontro = $connect->prepare("select distinct idorders	from orders_sn_specs where idorders = ".$v_ido." and typedata = 'UNIT' ");
  $sqlmmcontro->execute();
  $tieneUNIT="N";
  $resultcontrol = $sqlmmcontro->fetchAll();
   foreach ($resultcontrol as $roddDCw) {
      $tieneUNIT="Y";    
   }
 
			try {

        if ($v_st ==1)
        {
          $v_st ='true';
        }
        else
        {
          $v_st ='false';
        }
				 
        if ($tienerabbitcargado== 'Y')
        {
          $query_lista ="update orders_attributes set  v_boolean = ".$v_st." where  idorders =".$v_ido." and idattribute_orders =  1 ";
        
        }
        else
        {
          $query_lista ="INSERT INTO public.orders_attributes(idorders, idattribute_orders, datemodif, v_boolean, v_integer, v_double, v_string, v_date) VALUES (".$v_ido.", 1,now(),".$v_st.", NULL, NULL, NULL, NULL);";
        
        }
        $connect->query($query_lista);

        IF ( $tieneUNIT=="Y")
        {
          $query_lista ="INSERT INTO orders_states(idorders, idstate, datestate)	VALUES (".$v_ido.", 7, (now() + interval '3 minute') );";
          $connect->query($query_lista);	

          $sqlquery9999 = "update orders set active = 'Y' where idorders = ".$v_ido;
          $connect->query($sqlquery9999);

          	/// INSERT para SERVIDOR DE peticions :: petitions_server
								$v_id_station = 	$_SESSION["k"]  	 ; //id station for user business
								$iduuff = 	$_SESSION["a"];
								$iduu = 22; /// usuario del servidor
								$v_id_station = 13; // station del servidor;

								$parajson= '{"idorders":'.$v_ido.'}';
								$sqlpetiti ="INSERT INTO public.fas_petitions_server(
							idpetition, petitiontype, iduserfrom, iduserto, idstationto, instance, date, status, exitstatus, parameters1, parameters2, parameters3, idexterna)
							VALUES ((select COALESCE(max(idpetition),0) + 1 from fas_petitions_server), 2, ".$iduuff.", ".$iduu.", ".$v_id_station.",'04F', now(), 0, null, '".$parajson."', null, null, null);";


						//		$connect->query($sqlpetiti);

        }
        

    
        
        
        $return_result_insert="ok";
     

          	//////AUDITAMOS///////////////////////////////////////////////////////////////////////////////
							$vuserfas = $_SESSION["b"];
							$typeregister="SO";
							$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
							$vaccionweb="SetModuleRabbit";
							$vdescripaudit="SetModuleRabbit -idorder:".$v_ido." -module rabbit:".$v_st."- have unit set:".$tieneUNIT;
							$vtextaudit="idorder:".$v_ido." -module rabbit:".$v_st."- have unit set in table:".$tieneUNIT;
						
					
									$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
									$sentenciaudit->bindParam(':userfas', $vuserfas);								
									$sentenciaudit->bindParam(':menuweb', $vmenufas);
									$sentenciaudit->bindParam(':actionweb', $vaccionweb);
									$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
									$sentenciaudit->bindParam(':textaudit', $vtextaudit);
									$sentenciaudit->execute();
				
          $connect->commit();					
					/////////////////////////////////////////////////////////////////////////////////////

								
				} 
				catch (PDOException $e) 
				{
					
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ".$e->getMessage();						
					
				} 
		
 echo(json_encode(["resultiu"=>$return_result_insert,"erromsj"=>$msjerr]));

?>

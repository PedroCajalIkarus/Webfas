<?php

error_reporting(E_ALL);
 include("db_conect.php"); 
 
 	session_start();


     $vmaxid = $_REQUEST['dio'];
    	/// INSERT para SERVIDOR DE peticions :: petitions_server
        $v_id_station = 	$_SESSION["k"]  	 ; //id station for user business
        $iduuff = 	$_SESSION["a"];
        $iduu = 22; /// usuario del servidor
        $v_id_station = 13; // station del servidor;


        $sqlorde="update orders set active= 'Y',processfasserver=false  where idorders=  ".$vmaxid;
        $connect->query($sqlorde);

        $sqlorde="update orders_sn set  processfasserver=false  where idorders=  ".$vmaxid;
        $connect->query($sqlorde);
        ///////////////////////////////////////////////////

        $sqlm="SELECT orders_sn.idorders,  orders_sn.idnroserie 
        FROM orders_sn
        left join orders_sn_specs
        on  orders_sn_specs.idorders	=	orders_sn.idorders	and
            orders_sn_specs.idnroserie	=	orders_sn.idnroserie
        where orders_sn.idorders = ".$vmaxid." and orders_sn_specs.idnroserie is null";
    //   echo  $sqlm;

            $sql_busca_siexiste = $connect->prepare($sqlm);
            $sql_busca_siexiste->execute();
            $exite_idnube = "N";
            $resulrepair = $sql_busca_siexiste->fetchAll();
            foreach ($resulrepair as $rowbusca2) 
            {
                echo "<br>*->".$rowbusca2[0]."*->".$rowbusca2[1]."<br>";      

                $sqlupdar=" insert into orders_sn_specs 
                SELECT idorders, idrev, idch,  ".$rowbusca2[1].", typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, notes, idband, ulgain, dlgain, ulmaxpwr, dlmaxpwr
	            FROM public.orders_sn_specs
	            where idorders =  ".$vmaxid." and idnroserie= 0";
       
           //     echo "<br>".$sqlupdar;
                $sqlmma = $connect->prepare( $sqlupdar);
               $sqlmma->execute();
            }
        ////////////////////////////

        $parajson= '{"idorders":'.$vmaxid.'}';
        $sqlpetiti ="INSERT INTO public.fas_petitions_server(
    idpetition, petitiontype, iduserfrom, iduserto, idstationto, instance, date, status, exitstatus, parameters1, parameters2, parameters3, idexterna)
    VALUES ((select COALESCE(max(idpetition),0) + 1 from fas_petitions_server), 2, ".$iduuff.", ".$iduu.", ".$v_id_station.",'04F', now(), 0, null, '".$parajson."', null, null, null);";


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
 
echo "<br>Order sent to rework...";
?>
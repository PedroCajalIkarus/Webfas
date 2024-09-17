<?php
/*
foreach ($_POST as $key => $value) {
    echo "Nombre de la variable: ".$key ;
    echo "Valor de la variable: ".$value  ;
    echo "-------------------------"  ;
  } 
  */
  error_reporting(E_ALL);
  include("db_conect.php"); 
 //echo "<br>Recibido:<br>"; 


 // echo "elparametro2".$_POST['vv_idorders'];

  $vv_idorders = $_POST['vv_idorders'];
  $vv_idcustomers = $_POST['vv_idcustomers'];
  $vv_idfamilyprod = $_POST['vv_idfamilyprod'];
  $vv_idtypeband = $_POST['vv_idtypeband'];
  $vv_idtypeproduct = $_POST['vv_idtypeproduct'];
  $vv_idproduct = $_POST['vv_idproduct'];
  $vv_idconfiguration = $_POST['vv_idconfiguration'];
  $vv_idrev = $_POST['vv_idrev'];
  $vv_idnroserie = $_POST['vv_idnroserie'];
  $vv_so_soft_external = $_POST['vv_so_soft_external'];
  $vv_wo_serialnumber = $_POST['vv_wo_serialnumber'];
  $vv_idruninfo = $_POST['vv_idruninfo'];
  $vv_ponumber = $_POST['vv_ponumber'];
  $vv_pwrsupplytype = $_POST['vv_pwrsupplytype'];
  $vv_rcgfbwa = $_POST['vv_rcgfbwa'];
  $vv_moden_dig = $_POST['vv_moden_dig'];
  $vv_date_approved = $_POST['vv_date_approved'];
  $vv_descripcion = $_POST['vv_descripcion'];
  $vv_nameapproved = $_POST['vv_nameapproved'];
  $vv_typeregister = $_POST['vv_typeregister'];
  $vv_processday = $_POST['vv_processday'];
  $vv_processfasserver = $_POST['vv_processfasserver'];
  $vv_so_original = $_POST['vv_so_original'];
  $vv_so_associed = $_POST['vv_so_associed'];
  $vv_availablesn = $_POST['vv_availablesn'];
  $vv_idorders_nxt_trk = $_POST['vv_idorders_nxt_trk'];
  $vv_idnroserie_nxt_trk = $_POST['vv_idnroserie_nxt_trk'];

 

  $vv_idtypeproduct = $_POST['vv_idtypeproduct'];
  $vv_idconfiguration = $_POST['vv_idconfiguration'];
  $vv_powersupply = $_POST['vv_powersupply'];
  $vv_modelciu = $_POST['vv_modelciu'];
  $vv_description = $_POST['vv_description'];
  $vv_classproduct = $_POST['vv_classproduct'];
  $vv_active = $_POST['vv_active'];
  $vv_usermodif = $_POST['vv_usermodif'];
  $vv_datelastmodif = $_POST['vv_datelastmodif'];
  $vv_woparam = $_POST['vv_woparam'];
  $vv_showdpxreport = $_POST['vv_showdpxreport'];

  $vv_idbusiness = $_POST['vv_idbusiness'];
  $vv_iduniquebranchsonprod = $_POST['vv_iduniquebranchsonprod'];
  $vv_idbandgroup = $_POST['vv_idbandgroup'];
  $vv_idtypeproductaux = $_POST['vv_idtypeproductaux'];

  $vv_idrevproduct = $_POST['vv_idrevproduct'];
  $vv_fiplexsku = $_POST['vv_fiplexsku'];
  $vv_typeproduct = $_POST['vv_idtypeproduct'];

  $vv_sn = $_POST['vv_sn'];
  $vv_band0key = $_POST['vv_band0key'];
  $vv_band1key = $_POST['vv_band1key'];
  $vv_maxpwrkey = $_POST['vv_maxpwrkey'];
  $vv_classkey = $_POST['vv_classkey'];
  $vv_datetimesn = $_POST['vv_datetimesn'];
  $vv_qrcustomer = $_POST['vv_qrcustomer'];

  $vv_manualsku = $_POST['manualsku'];
  $vv_pfomszip = $_POST['pfomszip'];
  $vv_fpczip = $_POST['fpczip'];
  

        // primero chequeamos si existe fas_unitkeys
   //     echo "SELECT * from fas_unitkeys where sn = ". $vv_sn;
                  $rstmm = $connect->prepare("SELECT * from fas_unitkeys where sn = '".$vv_sn."'");
                  $rstmm->execute();
                  $resultado_m = $rstmm->fetchAll();		
                  $vexistesn = 0;
                  foreach ($resultado_m as $_POSTheadersmm) 
                  {
                    $vexistesn = 1;
                  }
                  if ($vexistesn == 0)
                  {
                    echo var_dump($_POST); 
                    
                    $sql = $connect->prepare("INSERT INTO public.fas_unitkeys(sn, band0key, band1key, maxpwrkey, classkey, datetimesn, qrcustomer) VALUES (:sn, :band0key, :band1key, :maxpwrkey, :classkey, :datetimesn, :qrcustomer);");
                    $sql->bindParam(':sn', $vv_sn);
                    $sql->bindParam(':band0key', $vv_band0key);
                    $sql->bindParam(':band1key', $vv_band1key);
                    $sql->bindParam(':maxpwrkey', $vv_maxpwrkey);
                    $sql->bindParam(':classkey', $vv_classkey);
                    $sql->bindParam(':datetimesn', $vv_datetimesn);
                    $sql->bindParam(':qrcustomer', $vv_qrcustomer);
                    
                    $sql->execute();
                  }
           // fin primero chequeamos si existe fas_unitkeys     
            // primero chequeamos si existe orders_sn
            $rstmm = $connect->prepare("SELECT * from orders_sn where wo_serialnumber = '". $vv_sn."' and so_soft_external='".$vv_so_soft_external."'");
            $rstmm->execute();
            $resultado_m = $rstmm->fetchAll();		
            $vexistesnso = 0;
            foreach ($resultado_m as $_POSTheadersmm) 
            {
              $vexistesnso = 1;
            }
            if ($vexistesnso == 0)
            {
              $sql = $connect->prepare("INSERT INTO public.orders_sn(idorders, idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, idrev, idnroserie, so_soft_external, wo_serialnumber, idruninfo, ponumber, pwrsupplytype, rcgfbwa, moden_dig, date_approved, descripcion, ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, nameapproved, notes, reqresources, typeregister, processday, processfasserver, so_original, so_associed, availablesn, idorders_nxt_trk, idnroserie_nxt_trk)               VALUES (:idorders, :idcustomers, :idfamilyprod, :idtypeband, :idtypeproduct, :idproduct, :idconfiguration, :idrev, :idnroserie, :so_soft_external, :wo_serialnumber, :idruninfo, :ponumber, :pwrsupplytype, :rcgfbwa, :moden_dig, :date_approved, :descripcion, :ul_gain, :ul_max_pwr, :dl_gain, :dl_max_pwr, :req_ppassy, :req_calibration, :req_spec, :req_other, :nameapproved, :notes, :reqresources, :typeregister, :processday, :processfasserver, :so_original, :so_associed, :availablesn, :idorders_nxt_trk, :idnroserie_nxt_trk);");
              $sql->bindParam(':idorders', $vv_idorders);
              $sql->bindParam(':idcustomers', $vv_idcustomers);
              $sql->bindParam(':idfamilyprod', $vv_idfamilyprod);
              $sql->bindParam(':idtypeband', $vv_idtypeband);
              $sql->bindParam(':idtypeproduct', $vv_idtypeproduct);
              $sql->bindParam(':idproduct', $vv_idproduct);
              $sql->bindParam(':idconfiguration', $vv_qvv_idconfigurationrcustomer);

              $sql->bindParam(':idrev', $vv_idrev);
              $sql->bindParam(':idnroserie', $vv_idnroserie);
              $sql->bindParam(':so_soft_external', $vv_so_soft_external);
              $sql->bindParam(':wo_serialnumber', $vv_wo_serialnumber);
              $sql->bindParam(':idruninfo', $vv_idruninfo);
              $sql->bindParam(':ponumber', $vv_ponumber);
              $vnull=null;
              $sql->bindParam(':pwrsupplytype', $vnull);
              $sql->bindParam(':rcgfbwa', $vnull);
              $sql->bindParam(':moden_dig', $vnull);
              $sql->bindParam(':date_approved', $vv_date_approved);
              $sql->bindParam(':descripcion', $vv_descripcion);
              $sql->bindParam(':ul_gain', $vnull);
              $sql->bindParam(':ul_max_pwr', $vnull);
              $sql->bindParam(':dl_gain', $vnull);
              $sql->bindParam(':dl_max_pwr', $vnull);
              $sql->bindParam(':req_ppassy', $vnull);
              $sql->bindParam(':req_calibration', $vnull);
              $sql->bindParam(':req_spec', $vnull);
              $sql->bindParam(':req_other', $vnull); 
              $sql->bindParam(':nameapproved', $vv_nameapproved);
              $sql->bindParam(':notes', $vnull); 
              $sql->bindParam(':reqresources', $vnull); 
              $sql->bindParam(':typeregister', $vv_typeregister);
              $sql->bindParam(':processday', $vv_processday);
              $sql->bindParam(':processfasserver', $vv_processfasserver);
              $sql->bindParam(':so_original', $vv_so_original);
              $sql->bindParam(':so_associed', $vv_so_associed);
              $sql->bindParam(':availablesn', $vv_availablesn);
              $sql->bindParam(':idorders_nxt_trk', $vv_idorders_nxt_trk);
              $sql->bindParam(':idnroserie_nxt_trk', $vv_idnroserie_nxt_trk);
              $sql->execute();
            }
     // fin primero chequeamos si existe fas_unitkeys      

        // primero chequeamos si existe products
   $rstmm = $connect->prepare("SELECT * from products where idproduct =".$vv_idproduct);
   $rstmm->execute();
   $resultado_m = $rstmm->fetchAll();		
   $vexistesn_idprod = 0;
   foreach ($resultado_m as $_POSTheadersmm) 
   {
     $vexistesn_idprod = 1;
   }
   if ($vexistesn_idprod == 0)
   {
     $sql = $connect->prepare("INSERT INTO public.products( idtypeproduct, idproduct, idconfiguration, powersupply, modelciu, description, classproduct, active, usermodif, datelastmodif, woparam, showdpxreport, idbusiness, iduniquebranchsonprod, idbandgroup, idtypeproductaux, idrevproduct, fiplexsku, typeproduct) VALUES (:idtypeproduct, :idproduct, :idconfiguration, :powersupply, :modelciu, :description, :classproduct, :active, :usermodif, :datelastmodif, :woparam, :showdpxreport, :idbusiness, :iduniquebranchsonprod, :idbandgroup, :idtypeproductaux, :idrevproduct, :fiplexsku, :typeproduct);");
     $sql->bindParam(':idtypeproduct', $vv_idtypeproduct);
     $sql->bindParam(':idproduct', $vv_idproduct);
     $sql->bindParam(':idconfiguration', $vv_idconfiguration);
     $sql->bindParam(':powersupply', $vv_powersupply);
     $sql->bindParam(':modelciu', $vv_modelciu);
     $sql->bindParam(':description', $vv_description);
     $sql->bindParam(':classproduct', $vv_classproduct);
     $sql->bindParam(':active', $vv_active);
     $sql->bindParam(':usermodif', $vv_usermodif);
     $sql->bindParam(':datelastmodif', $vv_datelastmodif);
     $sql->bindParam(':woparam', $vv_woparam);
     $sql->bindParam(':showdpxreport', $vv_showdpxreport);
     $sql->bindParam(':idbusiness', $vv_idbusiness);
     $sql->bindParam(':iduniquebranchsonprod', $vv_iduniquebranchsonprod);
     $sql->bindParam(':idbandgroup', $vv_idbandgroup);
     $sql->bindParam(':idtypeproductaux', $vv_idtypeproductaux);
     $sql->bindParam(':idrevproduct', $vv_idrevproduct);
     $sql->bindParam(':fiplexsku', $vv_fiplexsku);
     $sql->bindParam(':typeproduct', $vv_typeproduct);

    
     $sql->execute();

     $vv_manualsku = $_POST['manualsku'];
     $vv_pfomszip = $_POST['pfomszip'];
     $vv_fpczip = $_POST['fpczip'];

     
     
     $query_lista = "INSERT INTO public.products_attributes(idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)  VALUES (".$vv_idproduct.", 159, now(), NULL, NULL, NULL, '".$vv_manualsku."', NULL);";
     $connect->query($query_lista);
     $query_lista = "INSERT INTO public.products_attributes(idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)  VALUES (".$vv_idproduct.", 157, now(), NULL, NULL, NULL, '".$vv_pfomszip."', NULL);";
     $connect->query($query_lista);
     $query_lista = "INSERT INTO public.products_attributes(idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)  VALUES (".$vv_idproduct.", 158, now(), NULL, NULL, NULL, '".$vv_fpczip."', NULL);";
     $connect->query($query_lista);

   }
// fin primero chequeamos si existe fas_unitkeys    
   
?>
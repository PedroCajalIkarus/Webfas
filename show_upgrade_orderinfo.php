
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
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <link href="css/tabulator_bootstrap4.css" rel="stylesheet">
  <link rel="shortcut icon" href="fiplexcirculo-01.ico" />
  
  <link rel="stylesheet" href="toastr.css">
  
 <link href="css/tabulator_bulma.css" rel="stylesheet">
 
  
    <link rel="stylesheet" href="cssfiplex.css">
    <style>
	
    body
    {
          font-family: Arial, Helvetica, sans-serif;
              background:#eee;		  
      font-size:12px;
      font-size:10px;
    }
    table { font-size: 12px}

    
    </style>
    
</head>
<?php 

	
// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 

			
 
 	session_start();

 
        $soparam = $_REQUEST['soparam']; ///  
        $snparam = $_REQUEST['sn']; ///
        $v_idproduct_model =  $_REQUEST['sotextoamostrar']; ///
     
	 
      

        $sql= "select distinct orders_sn.*, modelciu,  quantity  from orders_sn 
        inner join orders on orders_sn.idorders = orders.idorders
        inner join products on products.idproduct = orders.idproduct
        where orders_sn.idorders =". $soparam." and wo_serialnumber = '". $snparam."' and idnroserie>0";
    //    echo "<br>".$sql;
        $sql= "select distinct orders_sn.*, modelciu,  quantity ,products.description descripcionciu from orders_sn 
        inner join orders on orders_sn.idorders = orders.idorders
        inner join products on products.idproduct = orders.idproduct
        where orders_sn.idorders =". $soparam."  and idnroserie =0 order by idrev desc limit 1";

   // echo "<br>".$sql;

							   $datacabez = $connect->query($sql)->fetchAll();
								$idtemp=0;
								$vejecucion = 1;
                               
								  foreach ($datacabez as $rowheaders) 
								  {
                                      $v_ppasy =  $rowheaders['req_ppassy'];
                                      $v_reqcalib =  $rowheaders['req_calibration'];
                                      $v_specialmat =  $rowheaders['req_spec'];
                                      $v_others =  $rowheaders['req_other'];
                                      $v_idrev =  $rowheaders['idrev'];
                                      $v_idproduct =  $rowheaders['idproduct'];
                                   
                                  }

                             
                                   $skucalculado =  $v_idproduct_model;
                                


									  ?>
                                      	<table class="table table-striped ">
            <tbody><tr><td><br></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr>    
                <td> <b>CIU: </b></td><td><?php echo $rowheaders['modelciu'];?></td>
               
            </tr>
            <tr>
            <th>Description CIU:<br></th><td colspan="5"> <?php echo $rowheaders['descripcionciu'];?></td>
            </tr>
            <tr>
            <th>Upgrade CIU:<br></th><td colspan="5"> <?php echo $skucalculado;?></td>
            </tr>
            <?php

$sqlm= "select *, v_boolean::integer as isboolean from products_attributes inner join products_attributes_type on products_attributes_type.idattribute =  products_attributes.idattribute   where products_attributes.idattribute in (94,95,96,97) and  products_attributes.idproduct =". $v_idproduct;

  //echo "<br>".$sqlm;
                       $datacabedet = $connect->query($sqlm)->fetchAll();
                        $idtemp=0;
                        $vejecucion = 1;

                        $array_licencias_habilitadas=array('');

                       
                          foreach ($datacabedet as $rowdet) 
                          {
                            if ( $rowdet['isboolean']==1)
                            {
                                $tipodesbloque= $rowdet['attributename'];
                                array_push($array_licencias_habilitadas, $tipodesbloque);
                            ?>
                                <tr>
            <th>Description:<br></th><td colspan="5"> <?php echo $rowdet['attributedescription'];?></td>
            </tr>
                            <?php
                            }
                    //        print_r($array_licencias_habilitadas);
                          }


                          $sqlm2= "select * from fas_unitkeys where  sn = '". $snparam."'" ;

                     //     echo "<br>HOLAMM".array_search("Unlocker2W",$array_licencias_habilitadas,true)."FIN";
                     //     echo "<br>HOLAMM".array_search("UnlockerClassA",$array_licencias_habilitadas,true)."FIN";
?>
    <tr>
            <th> <br></th><td colspan="5"></td>
            </tr>
<?php

                       $datacabedet2 = $connect->query($sqlm2)->fetchAll();
        
                       
                          foreach ($datacabedet2 as $rowdet3) 
                          {
                        //    echo $rowdet3['band0key'];
                            ?>

                              <?php
                              /////;  
                              $v="";
                              $v = array_search("UnlockerBand700",$array_licencias_habilitadas,true);
                             //  if ( $tipodesbloque=="UnlockerBand700")
                             if ( $v!="")
                                {?>

                                <tr>
                                  <th>Unlocker Band 0 - Key for SN#<?php echo $snparam; ?>:<br></th><td colspan="5"> <?php echo $rowdet3['band0key'];?></td>
                                </tr>


                                <?php }
                                $v="";
                                $v = array_search("UnlockerBand800",$array_licencias_habilitadas,true);
                             //   echo "<br>aa".$v."bv";
                                if ( $v!="")
                               //// if ( $tipodesbloque=="UnlockerBand800")
                                {?>

                                <tr>
                                  <th>Unlocker Band 1 - Key for SN#<?php echo $snparam; ?>:<br></th><td colspan="5"> <?php echo $rowdet3['band1key'];?></td>
                                </tr>

                                <?php  }

                                $v="";
                                $v = array_search("Unlocker2W",$array_licencias_habilitadas,true);  
                           //     echo "aaa".$v."bbbb";                            
                                if ( $v!="")
           ///                      if ( $tipodesbloque=="Unlocker2W")
                                {?>
                                <tr>
                                  <th>Unlocker2W (33dBm) - Key for SN#<?php echo $snparam; ?>:<br></th><td colspan="5"> <?php echo $rowdet3['maxpwrkey'];?></td>
                                </tr>
                                <?php }
                                
                                $v="";
                                $v = array_search("UnlockerClassA",$array_licencias_habilitadas,true);
                            //    echo "aaaccccc".$v."ddddbbbb";  
                                if ( $v!="")
                                //if ( $tipodesbloque=="UnlockerClassA")
                                {?>
                                <tr>
                                  <th>UnlockerClassA - Key for SN#<?php echo $snparam; ?>:<br></th><td colspan="5"> <?php echo $rowdet3['classkey'];?></td>
                                </tr>
                                <?php } ?>
                            <?php
                            
                          }
                          

            ?>
      
                           </tbody></table>
                 
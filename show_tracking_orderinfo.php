
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

     $sanitized_n = filter_var($_REQUEST['soparam'], FILTER_SANITIZE_STRING);
     if (filter_var($sanitized_n, FILTER_SANITIZE_STRING)) {
        $soparam = $_REQUEST['soparam']; ///
     }

     $sanitized_n = filter_var($_REQUEST['snparam'], FILTER_SANITIZE_STRING);
     if (filter_var($sanitized_n, FILTER_SANITIZE_STRING)) {
        $snparam = $_REQUEST['snparam']; ///
     }

	 
      

        $sql= "select distinct orders_sn.*, modelciu,  quantity  from orders_sn 
        inner join orders on orders_sn.idorders = orders.idorders
        inner join products on products.idproduct = orders.idproduct
        where orders_sn.idorders =". $soparam." and wo_serialnumber = '". $snparam."' and idnroserie>0";

        $sql= "select distinct orders_sn.*, modelciu,  quantity ,products.description descripcionciu from orders_sn 
        inner join orders on orders_sn.idorders = orders.idorders
        inner join products on products.idproduct = orders.idproduct
        where orders_sn.idorders =". $soparam."  and idnroserie =0 order by idrev desc limit 1";

//echo "<br>".$sql;

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

									  ?>
                                      	<table class="table table-striped ">
            <tbody><tr><td><br></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr>    
                <td> <b>CIU: </b></td><td><?php echo $rowheaders['modelciu'];?></td>
               
            </tr>
            <tr>
            <th>Description CIU:<br></th><td colspan="5"> <?php echo $rowheaders['descripcionciu'];?></td>
            </tr>
          
            <?php

 
	$sql = $connect->prepare("		select orders_attributes.*, v_boolean::int as v_booleanint,  attributename, attributedescription 
	from orders_attributes
	inner join orders_attributes_type
	on orders_attributes_type.idattribute = orders_attributes.idattribute_orders where orders_attributes_type.active not like '%XML%' and idorders = ".$soparam." " );    
   
	$sql->execute();
					$resulta_att = $sql->fetchAll();
                ///    echo "HOLA:".count($resulta_att);
                    if (count($resulta_att)> 0)
                    {
                        ?>  <tr><th><br><b>Attribute list:</b><hr>
                        <?php
                    
                    echo "<ul>";
					 foreach ($resulta_att as $row_atrib) 
					 {
						 
						 
                            if ($row_atrib['v_booleanint'] == 1) {
                                ?>
                                <p title='<?php echo $row_atrib['attributedescription']; ?>'>    &nbsp;<?php echo $row_atrib['attributename']; ?>&nbsp;<span class="badge bg-success">YES</span> <br>
                            </p> <?php
                             
                            } else {
                                ?>
                              <p title='<?php echo $row_atrib['attributedescription']; ?>'>  &nbsp;<?php echo $row_atrib['attributename']; ?>&nbsp;<span class="badge bg-danger">NO</span> <br>
                            </p><?php
                        ///    echo "Éxito!!! Se ha encontrado la palabra buscada en la posición: ".$posicion_coincidencia;
                            }
                         
                        ?>
                          

                                       
                          
                        <?php
                        	 

					 }
                     echo "</ul>  ";
                            
                            ?>

            </td><td></td><td></td><td></td> <td></td><td></td> </tr>
            <?php
            }
            ?>
            
            <tr><th><br><b>List of Attached Files:</b><hr>
                            <?php
                            	///search attach los 
	$sql = $connect->prepare("		select distinct idordersfileat,  replace(replace(orders_fileattach.namefileattach,seedtemp,''),'_','')  as  namefileattach , namefileattach as namefileattach2  from orders_fileattach
	inner join orders_sn on orders_sn.idorders  =  orders_fileattach.idorders 	where so_soft_external  in (select so_soft_external from  orders_sn where idorders = ".$soparam.") " );
	$sql->execute();
					$resultlistatt = $sql->fetchAll();
                    echo "<ul>";
					 foreach ($resultlistatt as $rowatt) 
					 {
						 
						$return_arr_listattac[] = array("idordersfileat" => $rowatt['idordersfileat'],								
						"namefileattach" => $rowatt['namefileattach'] ,
						"namefileattach2" => $rowatt['namefileattach2'] 											
						);

                            $posicion_coincidencia = strpos($rowatt['namefileattach2'], "pdf");
                         
                            //se puede hacer la comparacion con 'false' o 'true' y los comparadores '===' o '!=='
                            if ($posicion_coincidencia === false) {
                                ?>
                                <a href="" onclick="downfileattaso(0,'<?php echo $rowatt['namefileattach2']; ?>',0);return false;"><i class='fas fa-file-pdf' style='font-size:18px;color:red'></i>&nbsp;<?php echo $rowatt['namefileattach']; ?> </a><br>
                             <?php
                             
                            } else {
                                ?>
                                <a href="" onclick="openpfgdownfileattaso(0,'<?php echo $rowatt['namefileattach2']; ?>',0);return false;"><i class='fas fa-file-pdf' style='font-size:18px;color:red'></i>&nbsp;<?php echo $rowatt['namefileattach']; ?> </a><br>
                               <?php
                        ///    echo "Éxito!!! Se ha encontrado la palabra buscada en la posición: ".$posicion_coincidencia;
                            }
                         
                        ?>
                          

                                       
                          
                        <?php
                        	 

					 }
                     echo "</ul> </td><td></td><td></td><td></td> <td></td><td></td></tr>";
                            
                            ?>

            
                                      <?php			 
								  }
								  
			///// UNIT DPX CHANNEL
            if ($snparam=='')
            {
                $sql= "select distinct orders_sn_specs.*  from orders_sn 
                inner join orders_sn_specs on orders_sn.idorders = orders_sn_specs.idorders and
                orders_sn_specs.idnroserie = orders_sn.idnroserie 
                where orders_sn.idorders =". $soparam." and  orders_sn.idnroserie=0 and typedata ='UNIT' and orders_sn_specs.idrev = ".    $v_idrev ;
    
            }
            else
            {
                $sql= "select distinct orders_sn_specs.*  from orders_sn 
                inner join orders_sn_specs on orders_sn.idorders = orders_sn_specs.idorders and
                orders_sn_specs.idnroserie = orders_sn.idnroserie 
                where orders_sn.idorders =". $soparam." and wo_serialnumber = '". $snparam."' and orders_sn.idnroserie>0 and typedata ='UNIT' and orders_sn_specs.idrev = ".    $v_idrev ;
    
            }
         
    
    ?>
              <table class="table table-striped ">
          <!--  <tr>
                <th><b>UNIT (DL - UL) List</b></th><td></td><td></td><td></td>
                </tr> -->
    <?php
    
                                   $datacabez_unit = $connect->query($sql)->fetchAll();
                                    $idtemp=0;
                                    $vejecucion = 1;

                                    $uldain="NA";
                                    $dldain="NA";

                                    $ulmaxpwr="NA";
                                    $dlmaxpwr="NA";
                                   
                                      foreach ($datacabez_unit as $rowheaders_unit) 
                                      {
                                  //    echo "<tr><td>Unit DL: Start: <b>".$rowheaders_unit['unitdlstart']."</b> MHz</td><td>Unit DL: Stop: <b>".$rowheaders_unit['unitdlstop']."</b> MHz</td><td>Unit UL: Start: <b>".$rowheaders_unit['unitulstart']."</b> MHz</td> <td>Unit UL: Stop: <b>".$rowheaders_unit['unitulstop']."</b> MHz</td></tr>";
                                      
                                      $uldain=$rowheaders_unit['ulgain'];
                                      $dldain=$rowheaders_unit['dlgain'];
  
                                      $ulmaxpwr=$rowheaders_unit['ulmaxpwr'];
                                        if($rowheaders_unit['ulmaxpwr'] !="")
                                        {
                                            $ulmaxpwr=$rowheaders_unit['ulmaxpwr']; 
                                        }
                                        if ($rowheaders_unit['dlmaxpwr'] !="")
                                        {
                                            $dlmaxpwr=$rowheaders_unit['dlmaxpwr'];
                                        }
                                     
                                      }
                                      echo "<tr><td>  </td><td> </td><td> </td> <td> </td></tr>";
                                      echo "<tr><td>  <b> DL Gain: ".$dldain."</b> </td><td> <b>DL Max Pwr:". $dlmaxpwr."</b>  </td>  <td> <b>UL Gain:".$uldain."</b>  </td> <td><b>UL Max Pwr: ".$ulmaxpwr."</b>  </td> </tr>";
                                      
								  ?>
			   <tr>
                <td> <b>Quantity: </b></td><td><?php echo $rowheaders['quantity'];?></td>
                <td><b>PO Numbre:</b><td ><?php echo $rowheaders['ponumber'];?></td>
            </tr>
            <tr><td> </td><td> </td><td> 
        

        
            </td>
            <td> 
             </td></tr>

            <tr>
            <th>Description PO:<br></th><td colspan="5"> <?php echo $rowheaders['descripcion'];?></td>
            </tr>
            <tr><th>Notes PO:<br></th><td colspan="5"> <?php echo $rowheaders['notes'];?></td></tr>

            
         		     
                            
                            <tr><th><br></th><td></td><td><br></td><td></td></tr><tr><th><b>DPX (Low - High) List</b></th><td></td><td></td><td></td></tr>              
                            <?php

                            	///// UNIT DPX CHANNEL
                                if ($snparam=='')
                                {
                                    $sql= "select distinct orders_sn_specs.*  from orders_sn 
                                    inner join orders_sn_specs on orders_sn.idorders = orders_sn_specs.idorders  and
                                    orders_sn_specs.idnroserie = orders_sn.idnroserie
                                    where orders_sn.idorders =". $soparam." and orders_sn.idnroserie = 0 and typedata ='DPX'  and orders_sn_specs.idrev = ".    $v_idrev ;
                        
                                }
                                else
                                {
                                    $sql= "select distinct orders_sn_specs.*  from orders_sn 
                                    inner join orders_sn_specs on orders_sn.idorders = orders_sn_specs.idorders  and
                                    orders_sn_specs.idnroserie = orders_sn.idnroserie
                                    where orders_sn.idorders =". $soparam." and wo_serialnumber = '". $snparam."' and orders_sn.idnroserie>0 and typedata ='DPX'  and orders_sn_specs.idrev = ".    $v_idrev ;
                        
                                }
        
         
    
    $datacabez_unit = $connect->query($sql)->fetchAll();
     $idtemp=0;
     $vejecucion = 1;
    
       foreach ($datacabez_unit as $rowheaders_dpx) 
       {
       echo "<tr><td>DPX Low Start: <b>".$rowheaders_dpx['dpxlowstart']."</b> MHz</td><td>DPX Low Stop: <b>".$rowheaders_dpx['dpxlowstop']."</b> MHz</td><td>DPX High Start: <b>".$rowheaders_dpx['dpxhihgstart']."</b> MHz</td> <td>DPX High Stop: <b>".$rowheaders_dpx['dpxhihgstop']."</b> MHz</td></tr>";
       
       }

   ?>
    
                            
                            <tr><th><br></th><td></td><td><br></td><td></td></tr><tr><th><b>Channels List</b></th><td></td><td></td><td></td></tr>
                            
                            <?php

        ///// UNIT DPX CHANNEL
        if ($snparam=='')
        {
            $sqlmm= "select distinct orders_sn_specs.dl_ch_fr,ul_ch_fr   from orders_sn 
        inner join orders_sn_specs on orders_sn.idorders = orders_sn_specs.idorders  and
        orders_sn_specs.idnroserie = orders_sn.idnroserie
        where orders_sn.idorders =". $soparam."  and orders_sn.idnroserie>0 and typedata ='CHANNEL'  and orders_sn_specs.idrev = ".    $v_idrev ;
        }
        else
        {
            $sqlmm= "select distinct orders_sn_specs.dl_ch_fr,ul_ch_fr   from orders_sn 
            inner join orders_sn_specs on orders_sn.idorders = orders_sn_specs.idorders  and
            orders_sn_specs.idnroserie = orders_sn.idnroserie
            where orders_sn.idorders =". $soparam." and wo_serialnumber = '". $snparam."' and orders_sn.idnroserie>0 and typedata ='CHANNEL'  and orders_sn_specs.idrev = ".    $v_idrev ;
        }


//echo    $sql;

$datacabez_unit = $connect->query($sqlmm)->fetchAll();
$idtemp=0;
$vejecucion = 1;

foreach ($datacabez_unit as $rowheaders_ch) 
{
echo "<tr><td><b>DL Channels :</b></td><td><b>".$rowheaders_ch['dl_ch_fr']."</b> (MHz)</td><td><b>UL Channels :</b></td> <td><b>".$rowheaders_ch['ul_ch_fr']."</b> (MHz)</td></tr>";

}

?>
                            
                            <tr><td><b>Training required for PP-ASSY: </b></td><td>
                            <?php if (  $v_ppasy  == true )
                                        {
                                            ?><span class='btn btn-outline-success btn-xs'>Yes</span>
                                            <?php
                                        }
                                        else
                                        {
                                            ?><span class='btn btn-outline-danger btn-xs'>No</span>
                                            <?php
                                        }
                                                                         
                                        ?>
                             </td>
                            <td><b>Training required for Calibration:</b></td> <td> 
                                  
                            <?php if (  $v_pv_reqcalibpasy  == true )
                                        {
                                            ?><span class='btn btn-outline-success btn-xs'>Yes</span>
                                            <?php
                                        }
                                        else
                                        {
                                            ?><span class='btn btn-outline-danger btn-xs'>No</span>
                                            <?php
                                        }
                                        

                                    
                                        $v_specialmat =  $rowheaders['req_spec'];
                                        $v_others =  $rowheaders['req_other'];
                                        
                                        ?>
                                  </td>
                            </tr><tr><td><b>Special Material required: </b></td><td> 
                            <?php if (  $v_specialmat  == true )
                                        {
                                            ?><span class='btn btn-outline-success btn-xs'>Yes</span>
                                            <?php
                                        }
                                        else
                                        {
                                            ?><span class='btn btn-outline-danger btn-xs'>No</span>
                                            <?php
                                        }
                                        

                                        
                                        ?>
                            </td>
                            <td><b>Other:</b></td> <td>
                            <?php if (  $v_others  == true )
                                        {
                                            ?><span class='btn btn-outline-success btn-xs'>Yes</span>
                                            <?php
                                        }
                                        else
                                        {
                                            ?><span class='btn btn-outline-danger btn-xs'>No</span>
                                            <?php
                                        }
                                        

                                    
                                        
                                        ?>
                                  </td></tr>
                           </tbody></table>
                           <script type="text/javascript">
                               
		function openpfgdownfileattaso(idt,nomfilattdon ,idtm)
		{

		 
 
			window.open("https://webfas.fiplex.com/attachso/"+nomfilattdon, '_blank');
			return false;
			
		}
		function downfileattaso(idt,nomfilattdon ,idtm)
		{
			var a = document.createElement('a');
			a.setAttribute('href', 'https://webfas.fiplex.com/attachso/'+nomfilattdon);
			a.setAttribute('download', nomfilattdon);

			var aj = $(a);
			aj.appendTo('body');
			aj[0].click();
			aj.remove();
		}
		
                               </script>

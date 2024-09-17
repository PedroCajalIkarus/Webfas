<?php 
	
// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 
		
 
 	session_start();

 
        $soparam = $_REQUEST['idsoup']; ///  
        $snparam = $_REQUEST['sn']; ///
        $v_idproduct_model =  $_REQUEST['sotextoamostrar']; ///
     
	
        $sql= "select distinct orders_sn.*, modelciu,  quantity ,products.description descripcionciu,quantity
         from orders_sn 
        inner join orders on orders_sn.idorders = orders.idorders
        inner join products on products.idproduct = orders.idproduct
        where orders_sn.idorders =". $soparam."  and idnroserie =0 order by idrev desc limit 1";

   //  echo "<br>".$sql;

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
                                      $v_quantity_so = $rowheaders['quantity'];


                                      $v_quantity_asign =0;

                                      $v_quantity_asign = $rowheaders['quantity'];
                                      $sqlm="select count(distinct idnroserie ) as cc from orders_sn where idnroserie >0 and  orders_sn.idorders =". $soparam." ";
                                      $datadetqqq = $connect->query($sqlm)->fetchAll();
                                      foreach ($datadetqqq as $rowqqs)
                                      {
                                        $v_quantity_asign = $rowqqs['cc'];
                                      }
                                   
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
         
            <th>Assigned SN / Quantity   :<br></th><td colspan="5"> <?php echo $v_quantity_asign." / ". $v_quantity_so;?></td>
            </tr>
            <?php

$sqlm= "select *, v_boolean::integer as isboolean from products_attributes inner join products_attributes_type on products_attributes_type.idattribute =  products_attributes.idattribute   where products_attributes.idattribute in (94,95,96,97) and  products_attributes.idproduct =". $v_idproduct;

 // echo "<br>".$sqlm;
                       $datacabedet = $connect->query($sqlm)->fetchAll();
                        $idtemp=0;
                        $vejecucion = 1;

                        $array_licencias_habilitadas=array('');

                        $tieneupdra= 'N';
                          foreach ($datacabedet as $rowdet) 
                          {
                            $tieneupdra= 'Y';
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
             $faltansn =  $v_quantity_so - $v_quantity_asign;
                     
                          if ($tieneupdra== 'Y' &&  $faltansn > 0 )
                          {
            ?>
      
                       
             <tr><td colspan="6">             
					<label for="inputPassword" class="  col-form-label">Search SO / SN To Upgrade:</label>
				
						<select class="js-example-basic-single col-sm-12" required  id="txtlistciusup" name="txtlistciusup">
						</select>
                        </td></tr>    
                        
                     
          
                        <tr>
            <th>Old Part Number:<br></th><td colspan="5"> <span id="pnold" name="pnold"></span> </td>
            </tr>
            <tr>
            <th>New Part Number :<br></th><td colspan="5"> <span id="pnnew" name="pnnew"></span>  </td>
            </tr>
            <tr><td>
          <input type='hidden' name='idsodestno' id = 'idsodestno' value='<?php echo   $soparam;   ?>'>   
          <input type='hidden' name='idsociu' id = 'idsociu' value='<?php echo   $rowheaders['modelciu'];   ?>'>   
          
          </td><td></td> <td colspan="5"><button type="button" class="btn btn-primary btn-block" onclick="seteamoupgrade()" id="btnasignupgrade" disabled  name="btnasignupgrade">Assign SN to Upgrade </button></td></tr>
				  
            <?php } ?>
                      </tbody></table>
        
            <script type="text/javascript">



setTimeout(function(){ 
  $('.js-example-basic-single').select2();

  $('#txtlistciusup').select2({
 ajax: {
    url: "ajax_list_snbyupgrade.php",
    dataType: 'json',
    delay: 2,
    data: function (params) {
      return {
        q: params.term, // search term,
        idsociu: $("#idsociu").val(),
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

           

$("#txtlistciusup").change(function()
  {
    elsnselect = $("#txtlistciusup").val().split('|');
    $('#pnold').text(elsnselect[4]);
    $('#pnnew').text(elsnselect[5]);

    document.querySelector('#btnasignupgrade').disabled = false;
  });



}, 2000);



function seteamoupgrade()
{
  document.querySelector('#btnasignupgrade').disabled = true;

  elsnselect = $("#txtlistciusup").val().split('|');
  /////$row['idorders']."|".$row['idproduct']."|".$row['so_soft_external']."|".$row['wo_serialnumber']
  idsoorig = elsnselect[0];
  idsodestno =  $("#idsodestno").val();
  sn =elsnselect[3];
  idprodorig=elsnselect[1];
  soorig = elsnselect[2];
  

  $.ajax({
				url: 'ajaxupgrade_snso.php', 				
				data: "idsoorig="+idsoorig+'&idsodestno='+idsodestno+'&sn='+sn+'&idprodorig='+idprodorig+'&soorig='+soorig,					
				type: 'post',				
				datatype:'JSON',				
				cache:false,					
				success: function(data, status, xhr) {
					
				
					if (data.result =="ok" )
					{
						toastr["success"]("Save OK!", "");			
            show_po(idsodestno, 1);			
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

}


             </script> 

<?php
include "db_conect.php";
error_reporting(0);
/* Getting post data */
$nropage = $_REQUEST['page'];


 include ('licencefiplex_mm.php');
 
   //   $Encryption = new Encryption();



$sql = $connect->prepare("select count(*) as cc from  components_passives_coupler ");
    $sql->execute();
    $resultado = $sql->fetchAll();
	 foreach ($resultado as $row) {
		$allcount= $row['cc']+1;
	 }
	

		$rowid= 20;
		$nropage = $nropage -1;
		if($nropage ==0)
		{
			$rowid= 20;
			$rowperpage = $rowid * $nropage;			
		}
		if ($nropage==1)
		{
			$rowid=$allcount;
			$rowperpage=20;
		}
		if ($nropage==2)
		{
			$rowid=0;
			$rowperpage=0;
		}
				
		
	
        

$idcantrow=0;
$employee_arr = array();



	 $sql = $connect->prepare("SELECT products.idbusiness,  products.idproduct, products.idconfiguration, idcomppassivecoup, idcomprevcoup, coupfstart, coupfstop, coupling, couplinginsertloss, couplingisolation
	 ,modelciu, description , components_passives_coupler.active  	FROM public.components_passives_coupler
		 inner join products
		 on products.idproduct  = components_passives_coupler.idproduct");
    $sql->execute();
    $resultado = $sql->fetchAll();
	//$employee_arr[] = array("last_page" => $allcount);

	 foreach ($resultado as $row) {
		 $vidproduct =  $row['idproduct']; 
		// $idcantrow = $idcantrow +1;  
		$vidcomppassivecoup = $row['idcomppassivecoup'];
		$vidcomprevcoup = $row['idcomprevcoup'];
		$vmodelciu = $row['modelciu'];
		
		$vdescription = $row['description'];
		
		$vcoupfstart = $row['coupfstart'];
		$vcoupfstop = $row['coupfstop'];  
		$vcoupling = $row['coupling'];  
		
		$vcouplinginsertloss = $row['couplinginsertloss'];  
		$vcouplingisolation = $row['couplingisolation'];

		$vactive	 = $row['active'];

		
		$employee_arr[] = array("idproduct" => $vidproduct,"idcomppassivecoup" => $vidcomppassivecoup,"idcomprevcoup" => $vidcomprevcoup, "coupfstart" => $vcoupfstart ,
		"coupfstop" => $vcoupfstop, "coupling" => $vcoupling, "couplinginsertloss" => $vcouplinginsertloss, "couplingisolation" => $vcouplingisolation,
		 "active" => $vactive, "modelciu" => $vmodelciu , "description" => $vdescription);

	}


/* encoding array to JSON format */
$allcount=1;  // solo para q haga 1 llamado de trae datos
echo(json_encode(["last_page"=>$allcount, "data"=>$employee_arr,"a"=>$rowperpage]));


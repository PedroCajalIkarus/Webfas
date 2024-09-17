<?php
include "db_conect.php";
error_reporting(0);
/* Getting post data */
$nropage = $_REQUEST['page'];

	$allcount= 0;

	$rowid= 20;
	$nropage = 0;
	$rowid=0;
	$rowperpage=0;
				
		
	
        

$idcantrow=0;
$employee_arr = array();



	 $sql = $connect->prepare("SELECT products.*, idband.description as nombreband , objectband.* 
	 , nombportinul.description as  midportinul,  nombportoutul.description as  midportoutul, 
                    nombportindl.description as  midportindl, nombportoutdl.description as  midportoutdl
					 FROM products
	 inner join objectband
	 on objectband.ciu = products.modelciu
	 inner join idband
	 on idband.idband = objectband.idband
	 inner join idport as nombportinul
	 on nombportinul.idport  = objectband.idportinul
	  inner join idport as nombportoutul
	 on nombportoutul.idport  = objectband.idportoutul
	  inner join idport as nombportindl
	 on nombportindl.idport  = objectband.idportindl
	  inner join idport as nombportoutdl
	 on nombportoutdl.idport  = objectband.idportoutdl
	 where modelciu like 'DH7%'
		 ");
    $sql->execute();
    $resultado = $sql->fetchAll();
	//$employee_arr[] = array("last_page" => $allcount);

	 foreach ($resultado as $row) {
		 $vidproduct =  $row['idproduct']; 	
		$vmodelciu = $row['modelciu'];		
		$vdescription = $row['description'];

		$vvnombreband =  $row['nombreband'];
		
		$vvdlgain = $row['dlgain'];
		$vvulgain = $row['ulgain'];  
		$vvdlmaxpwr = $row['dlmaxpwr'];  
		$vvulmaxpwr = $row['ulmaxpwr'];  
		
		$vvmidportinul = $row['midportinul'];
		$vvmidportoutul = $row['midportoutul'];  
		$vvmidportindl = $row['midportindl'];  
		$vvmidportoutdl = $row['midportoutdl'];  

		$vactive	 = $row['active'];

		
		$employee_arr[] = array("idproduct" => $vidproduct,"dlgain" => $vvdlgain,"ulgain" => $vvulgain, "dlmaxpwr" => $vvdlmaxpwr ,	"ulmaxpwr" => $vvulmaxpwr, "nombreband" => $vvnombreband, "idportinul" => $vvmidportinul , "idportoutul" => $vvmidportoutul, "idportindl" => $vvmidportindl , "idportoutdl" => $vvmidportoutdl, "active" => $vactive, "modelciu" => $vmodelciu , "description" => $vdescription);

	}


/* encoding array to JSON format */
$allcount=1;  // solo para q haga 1 llamado de trae datos
echo(json_encode(["last_page"=>$allcount, "data"=>$employee_arr,"a"=>$rowperpage]));


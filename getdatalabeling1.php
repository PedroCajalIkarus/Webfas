<?php
include "db_conect.php";
error_reporting(0);
/* Getting post data */
$nropage = $_REQUEST['page'];


 include ('licencefiplex_mm.php');
 
   //   $Encryption = new Encryption();



$sql = $connect->prepare("select count(*) as cc from  products_labeling ");
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



	 $sql = $connect->prepare("SELECT * from  products_labeling order by ciu");
    $sql->execute();
    $resultado = $sql->fetchAll();
	//$employee_arr[] = array("last_page" => $allcount);

	 foreach ($resultado as $row) {
		 $vidlabel =  $row['idlabel']; 
		// $idcantrow = $idcantrow +1;  
		$vciu = $row['ciu'];
		$vulpwrrat = $row['ulpwrrat'];
		$vmadein = $row['madein'];  
		$vflia = $row['flia'];  
		$vfcc = $row['fcc'];  
		$vic = $row['ic'];  
		$vactive = $row['active'];  
		$vetsi = $row['etsi'];

		$vdescripcion = $row['description'];
		$vfccimg = $row['fccimg'];
		$vulimg = $row['ulimg'];
		$vrohsimg = $row['rohsimg'];
		$vmadeusaimg = $row['madeinimg'];
		
		$vetlnumber = $row['etlnumber'];
		$vintertekimg = $row['intertekimg'];
			
		
		$employee_arr[] = array("idlabel" => $vidlabel,"ciu" => $vciu,"ulpwrrat" => $vulpwrrat, "madein" => $vmadein ,
		"flia" => $vflia, "fcc" => $vfcc, "ic" => $vic, "etsi" => $vetsi, "active" => $vactive,"madeinimg" => $vmadeusaimg, 
		"descripcion" => $vdescripcion, "fccimg" => $vfccimg, "ulimg" => $vulimg, "rohsimg" => $vrohsimg,
		"etlnumber" => $vetlnumber, "intertekimg" => $vintertekimg);

	}


/* encoding array to JSON format */
$allcount=1;  // solo para q haga 1 llamado de trae datos
echo(json_encode(["last_page"=>$allcount, "data"=>$employee_arr,"a"=>$rowperpage]));


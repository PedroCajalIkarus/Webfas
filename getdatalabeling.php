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
		$allcount= $row['cc'];
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
				
		
	
        

	
	 $sql = $connect->prepare("SELECT * from  products_labeling order by ciu limit 5");
    $sql->execute();
    $resultado = $sql->fetchAll();




$employee_arr = array();
//$employee_arr[] = array("last_page" => $allcount);

$idcantrow=0;
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

		$vdescripcion = $row['descripcion'];
		$vfccimg = $row['fccimg'];
		$vulimg = $row['ulimg'];
		$vrohsimg = $row['rohsimg'];
		$vmadeusaimg = $row['madeinimg'];
		$active = $row['migrate'];
		
		
		$employee_arr[] = array("idlabel" => $vidlabel,"ciu" => $vciu,"ulpwrrat" => $vulpwrrat, "madein" => $vmadein ,
		"flia" => $vflia, "fcc" => $vfcc, "ic" => $vic, "etsi" => $vetsi, "active" => $vactive,"madeinimg" => $vmadeusaimg, 
		"descripcion" => $vdescripcion, "fccimg" => $vfccimg, "ulimg" => $vulimg, "rohsimg" => $vrohsimg);

	
}

/* encoding array to JSON format */
echo(json_encode(["total"=>$idcantrow, "records"=>$employee_arr,"a"=>$rowperpage]));


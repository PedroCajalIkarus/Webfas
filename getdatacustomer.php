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



	 $sql = $connect->prepare("select * from customers where active<> 'E' order by namecustomers");
    $sql->execute();
    $resultado = $sql->fetchAll();
	//$employee_arr[] = array("last_page" => $allcount);

	 foreach ($resultado as $row) {
		 $vvid =  $row['idcustomers']; 
		// $idcantrow = $idcantrow +1;  
			$vvnamecustomers = $row['namecustomers'];	
			$vvnactive= $row['active'];		
			$vvidcustomers= $row['idcustomers'];	

		$vvaddress= $row['address'];	
		$vvtelephone= $row['telephone'];	
		$vvemailcustom= $row['emailcustom'];	
		$vvpersoncontact= $row['personcontact'];				
		
		
		$employee_arr[] = array("idcustomers" => $vvidcustomers,"namecustomers" => $vvnamecustomers,"cliactive" => $vvnactive,"vvaddress" => $vvaddress,"vvtelephone" => $vvtelephone,"vvemailcustom" => $vvemailcustom,"vvpersoncontact" => $vvpersoncontact);

	}


/* encoding array to JSON format */
$allcount=1;  // solo para q haga 1 llamado de trae datos
echo(json_encode(["last_page"=>$allcount, "data"=>$employee_arr,"a"=>$rowperpage]));


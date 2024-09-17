<?php
include "db_conect.php";
error_reporting(0);
/* Getting post data */
$nropage = $_REQUEST['page'];


 include ('licencefiplex_mm.php');
 
   //   $Encryption = new Encryption();



$sql = $connect->prepare("select count(*) as cc from  fas_confidential_fw ");
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
				
		
	
        

	
	 $sql = $connect->prepare("SELECT idciu,modelciu, fpga, micro, eth, fas_confidential_fw.active FROM fas_confidential_fw inner join products on products.idproduct = fas_confidential_fw.idciu order by modelciu ");
    $sql->execute();
    $resultado = $sql->fetchAll();




$employee_arr = array();
//$employee_arr[] = array("last_page" => $allcount);

$idcantrow=1;
 foreach ($resultado as $row) {
		 $vidciu =  $row['idciu']; 
		
		$vmodelciu = $row['modelciu'];
		$vfpga = $row['fpga'];
		$vmicro = $row['micro'];  
		$veth = $row['eth'];  
		
		$vactive = $row['active'];  
		
		
		
		$employee_arr[] = array("idciu" => $vidciu,"modelciu" => $vmodelciu,"fpga" => $vfpga, "micro" => $vmicro ,		"eth" => $veth, "active" => $vactive);

	
}


/* encoding array to JSON format */
$allcount=1;  // solo para q haga 1 llamado de trae datos
echo(json_encode(["last_page"=>$allcount, "data"=>$employee_arr,"a"=>$rowperpage]));



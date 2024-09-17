<?php
include "db_conect.php";
error_reporting(0);
/* Getting post data */
$nropage = $_REQUEST['page'];


 include ('licencefiplex_mm.php');
 
   //   $Encryption = new Encryption();

/* Count total number of rows */
/*
when SUBSTRING(dateinfo,12,2)= '02' then 'A'
end as hrrango 
FROM runinfo ORDER BY fechamm desc,hr DESC, hrcorta desc  LIMIT ".$rowid.",".$rowperpage);
*/

$elwhere="";
	$param_search=$_POST['p'];
	$text_search=$_REQUEST['t'];
	
	$idempresaafil=$_REQUEST['idb'];


$sql = $connect->prepare("select count(*) as cc from  presales ");
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
				
		
	
        

	
	 $sql = $connect->prepare("select  pre.idpresales, namecustomers,ponumber, products.modelciu ciu, quantity,  date_approved ,coalesce(prestatus.idstate,0) as idstates
from presales as pre
inner join products
on products.idproduct = pre.idproduct  
inner join customers
on customers.idcustomers = pre.idcustomers
left join presales_states as  prestatus 
on prestatus.idpresales = pre.idpresales ORDER BY date_approved DESC  LIMIT ".$rowid." OFFSET ".$rowperpage);
    $sql->execute();
    $resultado = $sql->fetchAll();




$employee_arr = array();
//$employee_arr[] = array("last_page" => $allcount);

$idcantrow=1;
 foreach ($resultado as $row) {
	 $idpresales =  $row['idpresales'];
   // $idruninfo = $Encryption->encrypt($row['idruninfo'], $semillafp); // $row['idruninfo'];
	   
    $date_approved = substr($row['date_approved'],0,19);
    $ponumber = $row['ponumber'];
	$ciu = $row['ciu'];  
	$quantity = $row['quantity'];  
	$namecustomers = $row['namecustomers'];  
	$idstates = $row['idstates'];  
	if ($row['idstates']==1 )
	{
		$statename = "PO CheckList";
	}
	if ($row['idstates']==2 )
	{
		$statename = "CIU Parameters Config";
	}
	if ($row['idstates']==3 )
	{
		$statename = "Create SO";
	}
	if ($row['idstates']==4 )
	{
		$statename = " SNs Assignments";
	}
	

    $employee_arr[] = array("idpresales" => $idpresales,"date_approved" => $date_approved,"ponumber" => $ponumber, "ciu" => $ciu , "quantity" => $quantity, "idstates" => $idstates, "idstates2" => $idstates, "namecustomers" => $namecustomers);

	
}

/* encoding array to JSON format */
echo(json_encode(["last_page"=>$rowid, "data"=>$employee_arr,"a"=>$rowperpage]));


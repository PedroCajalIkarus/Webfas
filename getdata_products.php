<?php
include "db_conect.php";
error_reporting(0);
/* Getting post data */
$nropage = $_REQUEST['page'];
$xcantreg = $_REQUEST['size'];

 include ('licencefiplex_mm.php');
 
   //   $Encryption = new Encryption();



$sql = $connect->prepare("select count(*) as cc from  products ");
    $sql->execute();
    $resultado = $sql->fetchAll();
	 foreach ($resultado as $row) {
		$allcount= $row['cc']+1;
	 }
	

		$rowid= $xcantreg;
		$nropage = $nropage -1;
		if($nropage ==0)
		{
			$rowid= 200;
			$rowperpage = $rowid * $nropage;			
		}
		if ($nropage==1)
		{
			$rowid=$allcount;
			$rowperpage=20;
		}
		if ($nropage>=2)
		{
			$rowid=0;
			$rowperpage=0;
		}
				
		
	
        

$idcantrow=0;
$employee_arr = array();

//SELECT idcompdib, idcompdibrev, namedib, descriptiondib, gainul, gaindl, gaintolerance, maxpwrul, maxpwrdl, maxriple, acceptcalib, active, usermodif, datelastmodif

	 $sql = $connect->prepare("select familyproducts.namefamily as namefamily, typeband.description as typeband , 
       typeproducts.description as typeproducts, regulationproduct.description as typeregulation,
	   modelciu , products.active, products.descripcion as proddescrip
from products
inner join familyproducts
on familyproducts.idfamilyprod = products.idfamilyprod
inner join typeband
on typeband.idtypeband = products.idtypeband
inner join typeproducts
on typeproducts.idtypeproducts =  products.idtypeproduct
inner join regulationproduct
on regulationproduct.idregulation  = products.idregulation
where products.idfamilyprod <> 0  order by namefamily, typeband, typeproducts ,modelciu  LIMIT ".$rowid." OFFSET ".$rowperpage);


    $sql->execute();
    $resultado = $sql->fetchAll();
	//$employee_arr[] = array("last_page" => $allcount);

	 foreach ($resultado as $row) {
		 
		
		$v_namefamily = $row['namefamily'];
		$v_typeband = $row['typeband'];
		$v_typeproducts = $row['typeproducts'];  
		$v_typeregulation = $row['typeregulation'];  
		$v_typeregulation = $row['typeregulation'];  
		$v_modelciu = $row['modelciu']; 
		$v_proddescrip		= $row['proddescrip']; 
	
		if ($row['active'] =="Y") { $vactive="YES"; }
		if ($row['active'] =="N") { $vactive="NO"; }
		if ($row['active'] =="E") { $vactive="ERASE"; }
	
	  
		
		$employee_arr[] = array("namefamily" => $v_namefamily,"typeband" => $v_typeband,"proddescrip" => $v_proddescrip,"typeproducts" => $v_typeproducts,"typeregulation" => $v_typeregulation,"modelciu" => $v_modelciu,"active" => $vactive);

	}


/* encoding array to JSON format */
$allcount=1;
echo(json_encode(["last_page"=>$allcount, "data"=>$employee_arr,"a"=>$rowperpage]));


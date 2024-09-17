<?php
include "db_conect.php";
error_reporting(0);
/* Getting post data */
$nropage = $_REQUEST['page'];
$xcantreg = $_REQUEST['size'];

 include ('licencefiplex_mm.php');
 
   //   $Encryption = new Encryption();



$sql = $connect->prepare("select count(*) as cc from  components_dib ");
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

	 $sql = $connect->prepare("select components_dib.* 
	from components_dib
	inner join (
	SELECT idcompdib, max(idcompdibrev) as maxidcompdibrev
	from  components_dib 	group by idcompdib ) as comp_dib_rev
	on comp_dib_rev.idcompdib =  components_dib.idcompdib and
	   comp_dib_rev.maxidcompdibrev =  components_dib.idcompdibrev  order by components_dib.namedib  LIMIT ".$rowid." OFFSET ".$rowperpage);
    $sql->execute();
    $resultado = $sql->fetchAll();
	//$employee_arr[] = array("last_page" => $allcount);

	 foreach ($resultado as $row) {
		 $vidcompdib =  $row['idcompdib']."#".$row['idcompdibrev']; 
		 $vidcompdib2 =  $row['idcompdibrev']; 
		// $idcantrow = $idcantrow +1;  
		$vciu = $row['ciu'];
		$vnamedib = $row['namedib'];
		$vdescriptiondib = $row['descriptiondib'];  
		$vgainul = $row['gainul'];  
		$vgaindl = $row['gaindl'];  
		$vgaintolerance = $row['gaintolerance'];  

		$vacceptance = $row['acceptcalib'];  
	
		$vmaxpwrul = $row['maxpwrul'];  
		$vmaxpwrdl = $row['maxpwrdl'];  
		
		$vmaxriple = $row['maxriple'];  
		$vactive = $row['active'];  
		if ($row['active'] =="Y") { $vactive="YES"; }
		if ($row['active'] =="N") { $vactive="NO"; }
		if ($row['active'] =="E") { $vactive="ERASE"; }
	
	  
		
		$employee_arr[] = array("idcompdib" => $vidcompdib,"idcompdib2" => $vidcompdib2,"acceptance" => $vacceptance,"namedib" => $vnamedib,"descriptiondib" => $vdescriptiondib, "gainul" => $vgainul , "gaindl" => $vgaindl, "gaintolerance" => $vgaintolerance,
		"maxpwrul" => $vmaxpwrul, "maxpwrdl" => $vmaxpwrdl, "maxriple" => $vmaxriple,"active" => $vactive);

	}


/* encoding array to JSON format */
$allcount=1;
echo(json_encode(["last_page"=>$allcount, "data"=>$employee_arr,"a"=>$rowperpage]));


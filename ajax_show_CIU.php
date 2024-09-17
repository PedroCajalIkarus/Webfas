<?php
 include("db_conect.php"); 
	include("funcionesstores.php"); 
	header('Content-Type: application/json');
	$query_lista = list_show_CIU_by_SO($_REQUEST['idsaleorders']);
    $return_arr = array();
  //	echo $query_lista;				
	//exit();
	$data = $connect->query($query_lista)->fetchAll();						
	$letrasbuscadas = array("/", ".", ",", "-", );

	foreach ($data as $row) {
		$rowciu_sincaractraros = str_replace($letrasbuscadas, "", $row[0]);
		$return_arr[] = array("ciu" => $row[0],
                    "cant_sn" => $row['cc_sn'],
					"ciu_sincara" => $rowciu_sincaractraros , 
					"ifdualband" => $row['ifdualband2'] , 
					"arraysn" => $row['groupxsn'] , 
						"cantdib" => $row['cantdib'] , 
						"cantcalib" => $row['cantcalib'] , 
						"cantfinalchk" => $row['cantfinalchk'] 
                    );
					
		//echo $row[0].",".$row[1];
	 }
	
	
					
 echo json_encode($return_arr);
 
 



?>
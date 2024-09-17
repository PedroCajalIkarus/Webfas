<?php
try{
	
	/// SRv Test Fiplex cloud
	$vpassdbbucardo="EUT$Y6VdwvZx6-KJ";
	$ipservernube="107.191.42.48";
	$ipservernube="207.246.88.235";
	$ipservernube="192.168.60.26";
	
	$connectNUBE = new PDO('pgsql:host='.$ipservernube.';port=5432;dbname=dbfiplexrepli;user=bucardo;password='.$vpassdbbucardo);
	$connectNUBE->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
		
	
}catch(PDOException $e){
    echo "ERROR Conect Server: " . $e->getMessage();
	exit();

}

?>
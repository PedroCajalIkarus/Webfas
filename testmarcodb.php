<?php

	function make_safe($variable) {
$variable = strip_tags(mysql_real_escape_string(trim($variable)));
return $variable; }
	
	
	
try{
        // Conexión a la base de datos

	
	$ipservidorapache="127.0.0.1";

	
	 // Establecer tiempo de vida de la sesión en segundos
    $inactividad = 1200;
	
	$ipserver="127.0.0.1";
	$vuserdb="wfesbsuser001";
	$vpassdb="d-VcL{3D[Wef7pH=";
	$vdbname="dbfiplex";
	
	
	$folderservidor = ''; 
 
    $connect = new PDO('pgsql:host='.$ipserver.';port=5432;dbname='.$vdbname.';user='.$vuserdb.';password='.$vpassdb.'');
	//$connect->setAttribute(PDO::ATTRR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	
	//Fecha del servidor de base de datos.
	$sql = $connect->prepare('SELECT fnt_list_servertime(1)' );
	$sql->execute();
	$resultado = $sql->fetchAll();
	foreach ($resultado as $row) {
	
		   $Server_time=$row[0];
	
	 }
	echo "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa".$Server_time;
	
	echo make_safe("marco");
	
	
}catch(PDOException $e){
    echo "ERROR Conect Server: " . $e->getMessage();
?>
  <link rel="stylesheet" href="<?php echo $folderservidor; ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $folderservidor; ?>dist/css/adminlte.min.css">

<?php
	echo "  
	<div class='row'>
            <div class='col-6 col-sm-4'> </div>
            <div class='col-6 col-sm-4' align='center'><img src='Fipleximg.png' width='350px'> <br><p class='alert alert-danger'>  <img src='srvcaido.png' width='150px'>Error. #125° No Conect to Server</p></div>
            <div class='col-6 col-sm-4'> </div>
          </div><br><br> ";
	exit();
	//header("Location: http://".$ipservidorapache.$folderservidor."/log.php?m=".$e->getMessage());
}

?>
<?php
error_reporting(0);

try{
	
	/// inicio de control para mostrar info a usuarios validados
	$ipservidorapache="192.168.60.26";
	$ipservidorapache="webfas.honeywell.com";
		
		$ipserver="127.0.0.1";
	$vuserdb="wfeibpulseexr";
	$vuserdb="wfesbsuser001";
	$vpassdb="d-VcL{3D[Wef7pH=";
	$vdbname="dbfiplexrepli";
	$vdbname="dbfiplex";
	
	  $inactividad = 12000;
	
	$folderservidor = ''; 

	ini_set('max_input_vars', 4000);
	
	 	session_start();
	
//	echo "Hola:".$_SESSION["timeout"];
//	echo "<br>".isset($_SESSION["timeout"]);
//	exit();
	/*
 
 if(isset($_SESSION["b"])){
        // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
	//	echo "***********hola".time() - $_SESSION["timeout"];
        $sessionTTL = time() - $_SESSION["timeout"];
        if($sessionTTL > $inactividad){
			session_unset();
            session_destroy();
            header("Location: http://".$ipservidorapache."/index.php?t=timeoutinactivity");
        }
    }
	else
	{
			session_unset();
            session_destroy();
            header("Location: http://".$ipservidorapache."/index.php?t=notcookietimeout");
        
	}
	*/

	
	/// control para mostrar info a usuarios validados
	
        // Conexión a la base de datos

$_SESSION["timeout"] = time();
 
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
	$_SESSION["timeout"] = time();
	
	
}catch(PDOException $e){
//    echo "ERROR Conect Server: " . $e->getMessage();
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



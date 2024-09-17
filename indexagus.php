<?php 	  
///    error_reporting(0);
    
	function getPlatform($user_agent) {
   $plataformas = array(
      'Windows 10' => 'Windows NT 10.0+',
      'Windows 8.1' => 'Windows NT 6.3+',
      'Windows 8' => 'Windows NT 6.2+',
      'Windows 7' => 'Windows NT 6.1+',
      'Windows Vista' => 'Windows NT 6.0+',
      'Windows XP' => 'Windows NT 5.1+',
      'Windows 2003' => 'Windows NT 5.2+',
      'Windows' => 'Windows otros',
      'iPhone' => 'iPhone',
      'iPad' => 'iPad',
      'Mac OS X' => '(Mac OS X+)|(CFNetwork+)',
      'Mac otros' => 'Macintosh',
      'Android' => 'Android',
      'BlackBerry' => 'BlackBerry',
      'Linux' => 'Linux',
   );
   foreach($plataformas as $plataforma=>$pattern){
      if (preg_match('/(?i)'.$pattern.'/', $user_agent))
         return $plataforma;
   }
   return 'Otras';
}

try{	
 include("db_conect_login.php"); 
 $msjlogin="";
	if (isset($_POST['txtuser'])){
		
	//	 include ('licencefiplex_mm.php');
 
	//	 //   $Encryption = new Encryption();
		
		$vtxtuser = strtolower ($_POST['txtuser']);
		$vtxtpass = $_POST['txtpass'];
			session_start();
				// Guardar datos de sesión
			$_SESSION["timeout"] = time();
		$script_fnt= " fnt_ifuservalidencryp_simulate('".$vtxtuser."','".$vtxtpass."')";
		
		$sql = $connect->prepare("SELECT ".$script_fnt);
		$sql->execute();
		$resultado = $sql->fetchAll();
		$valido="0";
		foreach ($resultado as $row) 
		{
			$valido="1";
			$msjlogin="";
			$limpioroe = str_replace("(","",$row[0]);
			$limpioroe = str_replace(")","",$row[0]);
			$datosuserfas = explode(",", $limpioroe);
				// Comiendo de la sesión
			
				session_regenerate_id();
				$semilla_seed_business= $datosuserfas[5];
				///"("2019-12-06 13:48:23.504311-06",17,mmoretti,marco.moretti@fiplex.com,"Marco Moretti",7F1l1i6p1l3e0x,"",false)"
        $_SESSION["a"] = $datosuserfas[1];  //iduserfas
				$_SESSION["b"] = $datosuserfas[2]; //username
				$_SESSION["c"] = str_replace('"',"",$datosuserfas[4]);  //nombre
				$_SESSION["d"] = $datosuserfas[3]; //email
				$_SESSION["e"] = $datosuserfas[6]; //tel
				$_SESSION["f"] = $datosuserfas[7]; //tel
				
				$_SESSION["h"] = str_replace('"','',$datosuserfas[9]); //namebusiness
				$_SESSION["i"] = $datosuserfas[8]; //idbusiness
				$_SESSION["j"] = $datosuserfas[11]; //idbusiness
				
				//development
				//development
				if ($datosuserfas[10] =="true"  )
				{
					$_SESSION["g"] = "develop"; //tipo de usuario	
          $_SESSION["g"] = $datosuserfas[11] ; //tipo de usuario
				}
				else
				{
					$_SESSION["g"] = $datosuserfas[11] ; //tipo de usuario
					////$_SESSION["g"] = "develop"; //tipo de usuario	
				}
   //     $_SESSION["g"] = "quality"; //tipo de usuario	
  /// $_SESSION["g"] = $datosuserfas[10] ; //tipo de usuario
				/////////////////////////////////////////////////////////////////////////////////////
					if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
						   $ipauditar = $_SERVER['HTTP_CLIENT_IP'];
					} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
						   $ipauditar = $_SERVER['HTTP_X_FORWARDED_FOR'];
					} else {
						   $ipauditar = $_SERVER['REMOTE_ADDR'];
					}
					$SO = getPlatform($_SERVER['HTTP_USER_AGENT']);
				//////AUDITAMOS///////////////////////////////////////////////////////////////////////////////
				$vuserfas = $datosuserfas[2]; 
				$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
				$vaccionweb="logiweb";
				$vdescripaudit="logiweb#".$_SERVER['SERVER_ADDR'] ;
				$vtextaudit="conexion#".$ipauditar."#".$SO;
				
				
				
					$sql = $connect->prepare("select * from business_station_userfas inner join business_station
								on business_station.idbusiness = business_station_userfas.idbusiness and
								business_station.idstation =  business_station_userfas.idstation where business_station_userfas.active = 'true' and 
								 business_station_userfas.iduserfas = ".$_SESSION["a"]." and business_station_userfas.idbusiness = ".$_SESSION["i"]);
									 
						$sql->execute();
						$resultado_station = $sql->fetchAll();	
						
									

							$v_id_station = "";		
							$v_namestation = "NN";	
							
						foreach ($resultado_station as $rowstation) 
						{												
							$v_id_station = $rowstation["idstation"];		
							$v_namestation = $rowstation["namestation"];	
						
						}
		
						$_SESSION["k"] = 	$v_id_station ; //id station for user business
						$_SESSION["l"] = $v_namestation ; //name station for user business
			

				
				$sentenciach = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciach->bindParam(':userfas', $vuserfas);								
								$sentenciach->bindParam(':menuweb', $vmenufas);
								$sentenciach->bindParam(':actionweb', $vaccionweb);
								$sentenciach->bindParam(':descripaudit', $vdescripaudit);
								$sentenciach->bindParam(':textaudit', $vtextaudit);
								$sentenciach->execute();
								
							
				/////////////////////////////////////////////////////////////////////////////////////
				/////////////////////////////////////////////////////////////////////////////////////
		
				header("Location: https://".$ipservidorapache.$folderservidor."/home.php");
			
			
		}
			
		if ($valido=="0")
		{
			session_unset();
            session_destroy();
			$msjlogin="The username or password is incorrect";
		}			
		
	}
	
	}catch(PDOException $e){
    echo "ERROR Conect Server: " . $e->getMessage();
	}
    
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIPLEX | WEBFAS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $folderservidor; ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo $folderservidor; ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $folderservidor; ?>dist/css/adminlte.min.css">
   <link rel="stylesheet" href="<?php echo $folderservidor; ?>dist/css/adminlte.min.css">
  
  	<style>
	body
{
  font-family: Arial, Helvetica, sans-serif;
  
}
.btn-primary, .btn-primary:hover, .btn-primary:active, .btn-primary:visited {
    background-color: #0053a1;
}
</style>
  
  <!-- Google Font: Source Sans Pro -->
  
  <link rel="shortcut icon" href="fiplexcirculo-01.ico" />
</head>
<body class="hold-transition login-page">

<div class="login-box">
<img src="Fipleximg.png" width="350px">
  <div class="login-logo">
  
    <a href="index.php"><b>WEB</b>FAS</a>
	AGUS
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
	
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="indexagus.php" method="post" id="contactForm" class="needs-validation" novalidate>
        <div class="input-group mb-3">
          <input type="text" id="txtuser" name="txtuser" class="form-control" placeholder="User" required>
		  
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
		   <div class="invalid-tooltip">
            Please enter a Username
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" id="txtpass" name="txtpass" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
		   <div class="invalid-tooltip">
            Please enter a password
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
             <p class="text-danger"><?php echo $msjlogin;?></p>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>



     
      <!-- /.social-auth-links -->

     
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?php echo $folderservidor; ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo $folderservidor; ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $folderservidor; ?>dist/js/adminlte.min.js"></script>


<script type="text/javascript">
   
   (function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();




</script>
</body>
</html>

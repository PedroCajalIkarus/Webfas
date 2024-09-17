<?php 	  
    error_reporting(0);
    
 
 $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http";
/////echo  $protocol."---".$_SERVER['SERVER_PROTOCOL'] ;
if ($protocol =='http')
{
  header("Location: https://webfas.honeywell.com");
}

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
 $msjloginqr="";

 echo "HOLAA QR:".$_POST['txtqr'];
 
	if (isset($_POST['txtuser']) || isset($_POST['txtqr'])){
		
	//	 include ('licencefiplex_mm.php');
 
	//	 //   $Encryption = new Encryption();
		
		$vtxtuser = strtolower ($_POST['txtuser']);
		$vtxtpass = $_POST['txtpass'];
			session_start();
				// Guardar datos de sesión
			$_SESSION["timeout"] = time();

      $dondevalida = $_POST['txtqrh'];
 
      if ($dondevalida =="")
      {
        $script_fnt= " fnt_ifuservalidencryp_json('".$vtxtuser."','".$vtxtpass."')";
       
          $sql = $connect->prepare("SELECT ".$script_fnt);
      }
      else
      {
        $script_fnt= " fnt_ifuservalidencryp_byqr_json('".$_POST['txtqr']."')";
         
          $sql = $connect->prepare("SELECT ".$script_fnt);
         
      }


 
	
		$sql->execute();
		$resultado = $sql->fetchAll();
		$valido="0";
		foreach ($resultado as $row) 
		{
 
 

			$valido="1";
			$msjlogin="";
      $msjloginqr="";
			$limpioroe = str_replace("(","",$row[0]);
			$limpioroe = str_replace(")","",$row[0]);
			$datosuserfas = explode(",", $limpioroe);

      $a_resul = json_decode($row[0], true);
      
   
				// Comiendo de la sesión
        /*
        {"ff":"2022-08-11T14:42:25.661591-04:00","iduserfas":34,"username":"jcalaca","usermail":"john.calacaalves@honeywell.com",
          "nameuserfas":"John Calaca","seed":"7F1l1i6p1l3e0x","usermobile":"","userphoto":"false","idbusiness":1,
          "namebusiness":"FIPLEX","development":"assembler","fascategory":"Printer"}

          ("2022-08-11 15:45:29.58001-04",
          17,
          mmoretti,
          marco.moretti@honeywell.com,
          "Marco Moretti",
          7F1l1i6p1l3e0x,
          "",
          false,
          1, - 8
          FIPLEX,
          true, 10
          Engineering)
        */
			
				session_regenerate_id();
				$semilla_seed_business= $datosuserfas[5];
				///"("2019-12-06 13:48:23.504311-06",17,mmoretti,marco.moretti@fiplex.com,"Marco Moretti",7F1l1i6p1l3e0x,"",false)"
				$_SESSION["a"] = $a_resul["iduserfas"]; //$datosuserfas[1];  //iduserfas
				$_SESSION["b"] = $a_resul["username"]; // $datosuserfas[2]; //username
				$_SESSION["c"] = str_replace('"',"", $a_resul["nameuserfas"]);  //nombre
				$_SESSION["d"] = $a_resul["usermail"]; // $datosuserfas[3]; //email
				$_SESSION["e"] =  $a_resul["usermobile"]; // $datosuserfas[6]; //tel
				$_SESSION["f"] =  $a_resul["userphoto"]; //$datosuserfas[7]; //tel
				
				$_SESSION["h"] = str_replace('"','',$a_resul["namebusiness"]); //namebusiness
				$_SESSION["i"] = $a_resul["idbusiness"]; // $datosuserfas[8]; //idbusiness
				$_SESSION["j"] =  $a_resul["fascategory"]; //$datosuserfas[11]; //idbusiness
				
				//development
				if (  $a_resul["development"]   =="true"  )
				{
					$_SESSION["g"] = "develop"; //tipo de usuario	
				}
				else
				{
					$_SESSION["g"] = $a_resul["fascategory"]; // $datosuserfas[11] ; //tipo de usuario
					////$_SESSION["g"] = "develop"; //tipo de usuario	
				}
				
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
      $msjloginqr="The QR is Incorrect";
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
    body {
        font-family: Arial, Helvetica, sans-serif;

    }

    .btn-primary,
    .btn-primary:hover,
    .btn-primary:active,
    .btn-primary:visited {
        background-color: #0053a1;
    }
    </style>

    <!-- Google Font: Source Sans Pro -->

    <link rel="shortcut icon" href="fiplexcirculo-01.ico" />
</head>

<body class="hold-transition login-page">

    <div class="login-box">
        <img src="Fipleximg2020.png" width="350px">
        <div class="login-logo">

            <a href="index.php"><b>WEB</b>FAS</a>

        </div>
        <!-- /.login-logo -->
        <form action="indexraimundo.php" method="post" id="contactForm" class="needs-validation" novalidate>
            <div class="card">
                <div class="card-body login-card-body">


                    <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-content-above-home-tab" data-toggle="pill"
                                href="#custom-content-above-home" role="tab" aria-controls="custom-content-above-home"
                                aria-selected="false"> <span class="fa fa-qrcode"></span> &nbsp;QR</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="custom-content-above-profile-tab" data-toggle="pill"
                                href="#custom-content-above-profile" role="tab"
                                aria-controls="custom-content-above-profile" aria-selected="true"><span
                                    class="fas fa-user"></span> &nbsp;User / HID</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="custom-content-above-tabContent">
                        <div class="tab-pane fade active show" id="custom-content-above-home" role="tabpanel"
                            aria-labelledby="custom-content-above-home-tab">

                            <br>
                            <p class="login-box-msg">Sign in to start your session. </p>

                            <div class="input-group mb-3">

                                <br>
                                <input type="hidden" id="txtqrh" name="txtqrh" class="form-control" value="">
                                <input type="password" id="txtqr" name="txtqr" class="form-control" placeholder="QR"
                                    required>

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fa fa-qrcode"></span>
                                    </div>
                                </div>


                            </div>
                            <div class="icheck-primary">
                                <p class="text-danger"> <?php echo $msjloginqr;?></p>
                            </div>


                        </div>
                        <div class="tab-pane fade" id="custom-content-above-profile" role="tabpanel"
                            aria-labelledby="custom-content-above-profile-tab">

                            <br>
                            <p class="login-box-msg">Sign in to start your session. </p>

                            <div class="input-group mb-3">
                                <input type="text" id="txtuser" name="txtuser" class="form-control"
                                    placeholder="User / HID / E-Mail" required>

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
                                <input type="password" id="txtpass" name="txtpass" class="form-control"
                                    placeholder="Password" required>
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



                        </div>

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
                validaruser();

            }, false);
        });
    }, false);



    function validaruser() {
        if ($("#txtuser").val() != '' && $("#txtpass").val()) {
            document.forms[0].submit();
        }
    }

    var input = document.getElementById("txtqr");

    // Execute a function when the user presses a key on the keyboard
    input.addEventListener("keypress", function(event) {
        // If the user presses the "Enter" key on the keyboard
        if (event.key === "Enter") {
            // Cancel the default action, if needed
            event.preventDefault();
            // Trigger the button element with a click
            if (input.value != '') {
                $("#txtqrh").val(1);
                document.forms[0].submit();

                //txtqrh
            }

        }
    });
    </script>
</body>

</html>
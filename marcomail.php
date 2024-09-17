<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
error_reporting(E_ALL); 
 


  require("PHPMailer-master3/class.phpmailer.php");
   require("PHPMailer-master3/class.smtp.php");
  
   //   $mail = new PHPMailer(true);
      $mail = new PHPMailer();

 //Definimos las propiedades y llamamos a los métodos 

$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 4;

// Crea una nueva instancia de PHPMailer


// Configura el servidor SMTP
$mail->isSMTP();
$mail->Host = 'smtp.office365.com';
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

// Configura la autenticación

$mail->Username = "marco.moretti@honeywell.com";
//Password to use for SMTP authentication
$mail->Password = "QscWdv@152";

// Configura el correo electrónico del remitente

$mail->setFrom('marco.moretti@honeywell.com', 'Tech Support WEBFAS-FIPLEX');

// Configura el correo electrónico del destinatario
$mail->addAddress('marcusmoretti@gmail.com', 'marcus');

// Configura el asunto y el cuerpo del mensaje
$mail->Subject = 'Asunto del correo electrónico';
$mail->Body = 'Cuerpo del mensaje de correo electrónico';

// Envía el correo electrónico
if (!$mail->send()) {
    echo 'Error al enviar el correo electrónico: ' . $mail->ErrorInfo;
} else {
    echo 'Correo electrónico enviado correctamente.';
}

/*
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

   $mail->CharSet = 'UTF-8';

//Set the hostname of the mail server
$mail->Host = 'smtp.office365.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;
//Set the encryption system to use - ssl (deprecated) or tls
//$mail->SMTPSecure = 'SSL';
$mail->SMTPSecure = 'tls';
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "marco.moretti@honeywell.com";
//Password to use for SMTP authentication
$mail->Password = "QscWdv@152";

$mail->setFrom('marco.moretti@honeywell.com', 'Tech Support WEBFAS-FIPLEX');
//Set an alternative reply-to address
$mail->addReplyTo('marco.moretti@honeywell.com', 'Tech Support WEBFAS-FIPLEX');
//Set who the message is to be sent to
$mail->addAddress('marco.moretti@honeywell.com', 'marco ');
//$mail->addCC('agustin.corigliano@fiplex.com', 'Agus');



  //Asignamos asunto y cuerpo del mensaje
  //El cuerpo del mensaje lo ponemos en formato html, haciendo 
  //que se vea en negrita
  $mail->Subject = "Prueba de phpmailer webfas@fiplex.com";


 
    $mail->Body = "New Support Ticket from <b>MARCO test webfas@fiplex.com</b> -> IdRunInfo: 2423423 -- Issue: <b>TEST</b><br>";


  //Definimos AltBody por si el destinatario del correo no admite email con formato html 
  $mail->AltBody = "New Support Ticket from MARCO</b> -> IdRunInfo: 2423423 -- Issue: <b>TEST</b><br>";


  //se envia el mensaje, si no ha habido problemas 
  //la variable $exito tendra el valor true
echo "TEST SSL 587<br>";
   
        if (!$mail->Send()) {
            echo "Erro: " . $mail->ErrorInfo;
        } else {
           echo "ok listo enviado";
        }
		
		
		*/
		
		/*
 //Definimos las propiedades y llamamos a los métodos 

$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

   $mail->CharSet = 'UTF-8';

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;
//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'SSL';
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "fiplexwebfas@gmail.com";
//Password to use for SMTP authentication
$mail->Password = "Peugeot-208";

$mail->setFrom('fiplexwebfas@gmail.com', 'Tech Support WEBFAS-FIPLEX');
//Set an alternative reply-to address
$mail->addReplyTo('fiplexwebfas@gmail.com', 'Tech Support WEBFAS-FIPLEX');
//Set who the message is to be sent to
$mail->addAddress('marco.moretti@honeywell.com', 'marco ');
//$mail->addCC('agustin.corigliano@fiplex.com', 'Agus');



  //Asignamos asunto y cuerpo del mensaje
  //El cuerpo del mensaje lo ponemos en formato html, haciendo 
  //que se vea en negrita
  $mail->Subject = "Prueba de phpmailer 222";

 include("db_conect.php"); 
 
 		  $sql = $connect->prepare("select * from  runinfodb where idruninfo = 31021000360");
		  
	//	$sql->bindParam(':vvidpresales', $vvidpo);
		$sql->execute();
		$resultadostock = $sql->fetchAll();
		 foreach ($resultadostock as $rowstock) 
		{			
              $vvloginfo =  $rowstock['loginfo'];
				
		}
		$porciones = explode("\n", $vvloginfo);
		foreach ($porciones as &$valor) 
		{
			$pos =substr_count($valor, '###');
				
				//$pos2 = strstr($valor, '$$$',true);
				$pos2 =substr_count($valor, '$$$');
				
				
				//	if ($pos =="" &&  $pos2 =="" )	
					if ($pos ==0 &&  $pos2 ==0 )							
						{
					//	echo "".trim(substr($row[0],0,10))."\r\n".$valor;
						//echo "".$valor."\r\n";
						//$vmostrar = $vmostrar."-mm".$pos."mm-".$valor." *finlinea*\r\n";
						$posbr = 	strstr($valor, '<br>',true);
						if ($posbr =="")
						{
							
							$vmostrar = $vmostrar." ".$valor."<br>";
						}
						else
						{
						
							$vmostrar = $vmostrar." ".$valor;
							
						}
						
					//	$vmostrar = $vmostrar."".$valor."";
					} 
		}
 
    $mail->Body = "New Support Ticket from <b>MARCO</b> -> IdRunInfo: 2423423 -- Issue: <b>TEST</b><br>".$vmostrar;


  //Definimos AltBody por si el destinatario del correo no admite email con formato html 
  $mail->AltBody = "New Support Ticket from MARCO</b> -> IdRunInfo: 2423423 -- Issue: <b>TEST</b><br>".$vmostrar;


  //se envia el mensaje, si no ha habido problemas 
  //la variable $exito tendra el valor true

   
        if (!$mail->Send()) {
            echo "Erro: " . $mail->ErrorInfo;
        } else {
           echo "ok listo enviado";
        }

*/


   ?>
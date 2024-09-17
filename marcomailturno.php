<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
error_reporting(E_ALL); 
  require("PHPMailer-master3/class.phpmailer.php");
   require("PHPMailer-master3/class.smtp.php");
  
      $mail = new PHPMailer(true);
	

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

$mail->setFrom('fiplexwebfas@gmail.com', 'Martillero ARTAZA TURNOS');
//Set an alternative reply-to address

//Set who the message is to be sent to
$mail->addAddress('marcusmoretti@gmail.com', 'marco ');
//$mail->addCC('agustin.corigliano@fiplex.com', 'Agus');



  //Asignamos asunto y cuerpo del mensaje
  //El cuerpo del mensaje lo ponemos en formato html, haciendo 
  //que se vea en negrita
  $mail->Subject = "ASIGNACION DE TURNO - 10-06-2020";

 
    $mail->Body = " Sr. Moretti Marcos, a continuación le brindaos los datos del turno solicitado. Asimismo, de no poder asistir se le ruega se comunique nuevamente a los fines de ser cancelado con una antelación de 2hs. Atte. 
<br>
NUMERO DE TURNO: 00127
<br>
NOMBRE: MORETTI MARCOS
<br>
LUGAR IDENTIFICACION: 27 DE ABRIL 564, PISO 1, OF. B
<br>
FECHA TURNO: 10/06/2020
<br>
HORA: 15:15
<br>
CORREDOR PUBLICO: ARTAZA V. MARTIN 
<br>
OBSERVACIONES: TOLERANCIA DE ESPERA DE HASTA 15 MINUTOS
<br><br><br>
Victor Martin Artaza<br>
MARTILLERO PUBLICO Y JUDICIAL<br>
M.P. 05-3039 - M.P. 01-2426<br>
CORREDOR PUBLICO <br>
M.P. 04-3791<br>
Cel: 351-2777145<br>";


  //Definimos AltBody por si el destinatario del correo no admite email con formato html 
  $mail->AltBody = "New Support Ticket from MARCO</b> -> IdRunInfo: 2423423 -- Issue: <b>TEST</b><br>".$vmostrar;


  //se envia el mensaje, si no ha habido problemas 
  //la variable $exito tendra el valor true

   
        if (!$mail->Send()) {
            echo "Erro: " . $mail->ErrorInfo;
        } else {
           echo "ok listo enviado";
        }


   ?>
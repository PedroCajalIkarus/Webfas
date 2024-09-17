<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
//error_reporting(E_ALL); 
error_reporting(0);
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
$mail->Host = 'smtp.office365.com';
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
$mail->Username = "webfas@fiplex.com";
//Password to use for SMTP authentication
$mail->Password = "W3bF4sFiplex$";

$mail->setFrom('webfas@fiplex.com', 'Tech Support WEBFAS-FIPLEX');
//Set an alternative reply-to address
$mail->addReplyTo('webfas@fiplex.com', 'Tech Support WEBFAS-FIPLEX');

?>
<?php

$method = $_SERVER['REQUEST_METHOD'];
if($method == 'POST'){
$requestBody = File_get_contents("php://input");
$json = json_decode($requestBody);

$email = $json->queryResult->parameters->userEmail;
$name = $json->queryResult->parameters->userName;
$m = $json->queryResult->parameters->userMessage;

require("class.phpmailer.php");
require("class.smtp.php");

$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

$mail->IsSMTP(); // telling the class to use SMTP

try {
  //$mail->Host       = "mail.yourdomain.com"; // SMTP server
  $mail->SMTPDebug  = 0;                     // disables SMTP debug 
  $mail->SMTPAuth   = true;                  // enable SMTP authentication
  $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
  $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
  $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
  $mail->Username   = "rizonn707@gmail.com";  // GMAIL username
  $mail->Password   = "rizon96";            // GMAIL password
  //$mail->AddReplyTo('name@yourdomain.com', 'First Last');
  $mail->AddAddress('mahdicherham7@gmail.com');
  $mail->SetFrom($email, 'Codendot-Chatbot');
  //$mail->AddReplyTo('name@yourdomain.com', 'Fi Last');
  $mail->Subject = 'Automated Codendot-Chatbot Email';
  $mail->IsHTML(true);
  $mail->Body = 'From: ' . $name . '<br>Email: ' . $email . '<br>Message: ' . $m ;
  //$mail->MsgHTML(file_get_contents('contents.html'));
  //$mail->AddAttachment('images/phpmailer.gif');      // attachment
  //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
  $mail->Send();
  $speech = "I have successfully sent your message.";
  
} catch (phpmailerException $e) {
	$speech = "Error, I could not send your message.";
} catch (Exception $e) {
	$speech = "Error,  I could not send your message.";
}
}
else {
	$speech = "Error, I could not send your message.";
}
	$response = new \stdClass();
	$response->fulfillmentText = $speech;
	echo json_encode($response);
?>

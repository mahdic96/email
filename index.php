<?php

$method = $_SERVER['REQUEST_METHOD'];
if($method == 'POST'){
$requestBody = File_get_contents("php://input");
$json = json_decode($requestBody);
$action = $json->queryResult->action;

if(strcmp($action, 'sendEmail') == 0){

$email = $json->queryResult->parameters->userEmail;
$name = $json->queryResult->parameters->userName;
$m = $json->queryResult->parameters->userMessage;


require("class.phpmailer.php");
require("class.smtp.php");

$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
$mail2= new PHPMailer(true);
$mail->IsSMTP(); // telling the class to use SMTP
$mail2->IsSMTP();
try {
  //$mail->Host       = "mail.yourdomain.com"; // SMTP server
  $mail->SMTPDebug  = 0;                     // disables SMTP debug 
  $mail->SMTPAuth   = true;                  // enable SMTP authentication
  $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
  $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
  $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
  $mail->Username   = "cndchatbot@gmail.com";  // GMAIL username
  $mail->Password   = "Cnd*123654";            // GMAIL password

  $mail->AddAddress('info@codendot.com');
  $mail->SetFrom($email, 'Codendot-Chatbot');
  //$mail->AddReplyTo('name@yourdomain.com', 'Fi Last');
  $mail->Subject = 'Automated Codendot-Chatbot Email';
  $mail->IsHTML(true);
  $mail->Body = 'From: ' . $name . '<br>Email: ' . $email . '<br>Message: ' . $m ;
  //$mail->MsgHTML(file_get_contents('contents.html'));
  //$mail->AddAttachment('images/phpmailer.gif');      // attachment
  //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
  $mail->Send();
  $speech = "Great! I have successfully sent your email to our support team, they will contact you as soon as possible, you will also receive an automated email from Codendot for your information. Anything else I can help you with?";
 
	//email to the customer
  $mail2->SMTPDebug  = 0;                     // disables SMTP debug 
  $mail2->SMTPAuth   = true;                  // enable SMTP authentication
  $mail2->SMTPSecure = "ssl";                 // sets the prefix to the servier
  $mail2->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
  $mail2->Port       = 465;                   // set the SMTP port for the GMAIL server
  $mail2->Username   = "cndchatbot@gmail.com";  // GMAIL username
  $mail2->Password   = "Cnd*123654";            // GMAIL password

  $mail2->AddAddress($email);
  $mail2->SetFrom('cndchatbot@gmail.com', 'Codendot-Chatbot');
  //$mail->AddReplyTo('name@yourdomain.com', 'Fi Last');
  $mail2->Subject = 'Automated Email – Codendot Support - Please do not reply';
  $mail2->IsHTML(true);
  $mail2->Body = 'Thanks for contacting codendot!<br><br>This is just a quick confirmation that we have received the following message from you and we will respond to you as soon as we can.<br><br>Your Message: ' . $m .'<br><br>Best,<br><br>A.I.D.A';
  //$mail->MsgHTML(file_get_contents('contents.html'));
  //$mail->AddAttachment('images/phpmailer.gif');      // attachment
  //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
  $mail2->Send();

 
} catch (phpmailerException $e) {
	$speech = "Error, I could not send your message.";
} catch (Exception $e) {
	$speech = "Error,  I could not send your message.";
}

else {
	$speech = "Error, I could not send your message.";
}
	$response = new \stdClass();
	$response->fulfillmentText = $speech;
	echo json_encode($response);
}

elseif (strcmp($action, 'callme') == 0) {
	$number = $json->queryResult->parameters->phoneNumber;
	$m = $json->queryResult->parameters->services;
	$name = $json->queryResult->parameters->name;
	
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
  $mail->Password   = "hunter96@";            // GMAIL password

  $mail->AddAddress('info@codendot.com');
  $mail->SetFrom($email, 'Codendot-Chatbot');
  //$mail->AddReplyTo('name@yourdomain.com', 'Fi Last');
  $mail->Subject = 'Automated Codendot-Chatbot Email - Call Request';
  $mail->IsHTML(true);
  $mail->Body = 'Call request from: ' . $name . '<br>Phone number: ' . $number . '<br>Message: ' . $m ;
  //$mail->MsgHTML(file_get_contents('contents.html'));
  //$mail->AddAttachment('images/phpmailer.gif');      // attachment
  //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
  $mail->Send();
  $speech = "We will call you as soon as possible on the number that you have provided ".$number.".";
 

 
} catch (phpmailerException $e) {
	$speech = "Error, I could not send your message.";
} catch (Exception $e) {
	$speech = "Error,  I could not send your message.";
}

else {
	$speech = "Error, I could not send your message.";
}
	$response = new \stdClass();
	$response->fulfillmentText = $speech;
	echo json_encode($response);
}
}

?>

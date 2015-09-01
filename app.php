<?php

require 'vendor/autoload.php';

// Set up parameters
$host = 'smtp-in.unisender.com';
$username = '';
$password = '';
$to = '';
$to2 = '';
$from = ''; // should be verified before using
$subject = 'UniGrid test email subject';
$body = file_get_contents('./resources/simple-body.html');
$txt = file_get_contents('./resources/alt-body.txt');

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPDebug = 2; // Display all information about server-client communication.
$mail->CharSet = 'utf-8';
$mail->Encoding = '7bit'; // Available values "8bit", "7bit", "binary", "base64", and "quoted-printable".
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
$mail->Host = $host;
$mail->Port = 465;
$mail->Username = $username;
$mail->Password = $password;
$mail->SetFrom($from);
$mail->Subject = $subject;
$mail->Body = $body;
$mail->IsHTML(true);
$mail->AltBody = $txt;

$mail->AddAttachment('./resources/attachment.html');// Add html attachment file to the email
$mail->AddEmbeddedImage('./resources/embedded-content.png', '123');// Add embedded image to the email
/* // Write two slashes at the beginning to uncomment single email sending and single slash to uncomment multiple addresses sending.
// Single email sending
$mail->AddAddress($to);
/*/
// PHPMailer requires To address, but if you use X-UO-RECIPIENT header, To address will be ignored by UniOne.
$mail->AddAddress($to);
$mail->AddCustomHeader("X-UO-RECIPIENT", '{"email": "'.$to.'","substitutions": {"fname": "John","lname": "Dow"}}');
$mail->AddCustomHeader("X-UO-RECIPIENT", '{"email": "'.$to2.'","substitutions": {"fname": "Jane","lname": "Dow"}}');
//*/
if ($mail->Send()) {
	echo "Message was sent successfully\n";
} else {
	echo "Unable to send the message\n";
}
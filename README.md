# unione-smtp-example

In PHP using PHPMailer
```
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

```

In Ruby
```
#!/usr/bin/env ruby

require 'mail'

options = {
  :address => 'smtp-in.unisender.com',
  :port => 587, #or 25
  :user_name => 'username',
  :password => 'SomePassword',
  :authentication => 'plain', #or 'login'
  :enable_starttls_auto => true,
}

Mail.defaults do
  delivery_method :smtp, options
end

mail = Mail.new do
  from 'vasyapupkin@gmail.com'
  to [ 'vasyapupkin1@gmail.com', 'petyapupkin1@gmail.com' ]
  subject 'Test NEW mail'
  header['X-UO-RECIPIENT'] = '{"email": "vasyapupkin1@gmail.com", "substitutions": {"fname": "Vasiliy"}}'
  header['X-UO-RECIPIENT'] = '{"email": "petyapupkin1@gmail.com", "substitutions": {"fname": "Petr"}}'
  text_part do
    body 'Welcome to our service!'
  end
  html_part do
    content_type 'text/html; charset=UTF-8'
    body "<h1>Welcome to our service, {{fname}}!</h1><br>Message sent at: #{Time.now}"
  end
end

mail.deliver!
```

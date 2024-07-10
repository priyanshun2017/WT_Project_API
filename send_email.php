<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Adjust based on your installation method

$mail = new PHPMailer(true); // Enable exceptions

// SMTP Configuration
$mail->isSMTP();
$mail->Host = 'live.smtp.mailtrap.io'; // Your SMTP server
$mail->SMTPAuth = true;
$mail->Username = 'PRIYANSHU NIRANJAN'; // Your Mailtrap username
$mail->Password = 'aKhn*k3fQZ33U-9'; // Your Mailtrap password
$mail->SMTPSecure = 'tls';
$mail->Port = 2525;

// Sender and recipient settings
$mail->setFrom('priyanshun2017@ptuniv.edu.in', 'From Name');
$mail->addAddress('priyanshun2017@ptuniv.edu.in', 'Recipient Name');

// Sending plain text email
$mail->isHTML(false); // Set email format to plain text
$mail->Subject = 'Your Subject Here';
$mail->Body    = 'This is the plain text message body';

// Send the email
if(!$mail->send()){
    echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}


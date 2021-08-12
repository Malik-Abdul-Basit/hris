<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Mailer = "smtp";
// 0 = off (for production use, No debug messages) debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPDebug = 0;
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->SMTPAuth = TRUE;
//$mail->SMTPAutoTLS = FALSE
//$mail->SMTPSecure = "SSL";
//$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->CharSet = 'UTF-8';

$mail->Port = 25;
$mail->Host = "mail.medcaremso.com";
$mail->Username = 'hris@medcaremso.com';
$mail->Password = '9qlUeYa+ZlLq';
$mail->setFrom("hris@medcaremso.com", "HRIS");
$mail->addReplyTo("hris@medcaremso.com", "HRIS");

// Attachments
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

$mail->isHTML(true);

/*$parameters = [
    'subject' => 'subject',
    'data' => [
        'email_body' => $mail_body['html'],
        'message' => $mail_body['message'],
    ],
    'replyTo' => [
        'email'=>$replyTo_email,
        'name'=> $replyTo_user_name,
    ],
    'mailTo' => [
        'email' => $email,
        'name' => $user_name,
    ],
    'cc' => [
        'email'=>$cc_email,
        'name'=> $cc_user_name
    ],
    'bcc' => [
        'email'=>$bcc_email,
        'name'=> $bcc_user_name
    ],
];*/

?>
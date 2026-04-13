<?php
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;

include_once("mailer_config.php")
//$mail->Username = 'navn@gmail.com';
//$mail->Password = 'App-passord';


$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('no-reply@gmail.com', 'Ingen svar');
$mail->addAddress('brukerens@mail.com');

$mail->Subject = 'Subect-feltet';
$mail->Body = 'Mailens innhold';

if($mail->send()) {
    echo "E-post sendt!";
} else {
    echo "Feil: " . $mail->ErrorInfo;
}
?>
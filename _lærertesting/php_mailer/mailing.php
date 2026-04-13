<?php
//Sjekk at stiene blir riktig o fohold ti lhvor denne filen ligger
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;

include_once("mailer_config.php")
//"mailer_config.php" inneholder de to linjene under.
//Sett inn passende info i denne filen, 
// Om du bruker git,- Husk å legge inn:  **/mailer_config.php
// og evt: **/PHPMailer/   

// $mail->Username = 'navn@gmail.com';
//$mail->Password = 'App-passord';


$mail->SMTPSecure = 'tls';
$mail->Port = 587;

//Disse må du selv sette
$mail->setFrom('no-reply@gmail.com', 'Ingen svar');
$mail->addAddress('mottaker.brukerens.mailadresse@mail.com');

//Disse må du endre og sette inn passende tekst selv
$mail->Subject = 'Subect-feltet';
$mail->Body = 'Mailens innhold';

if($mail->send()) {
    echo "E-post sendt!";
} else {
    echo "Feil: " . $mail->ErrorInfo;
}
?>
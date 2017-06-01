<?php

function sendMail($senderName, $sender, $to, $subject, $text) {
    include_once("./application/libs/phpmailer/class.phpmailer.php");
    include_once("./application/libs/phpmailer/class.smtp.php");

    if (!class_exists("PHPMailer")) {
        return false;
    }
    $mail = new PHPMailer();
    $mail->IsSMTP();                                        // SMTP-n keresztüli küldés
    $mail->Host = "mail.feree.hu:26";                  // SMTP szerverek

    $mail->SMTPAuth = true;                                 // SMTP autentikáció bekapcs
    $mail->Username = "onlineszemetes@feree.hu";                           // SMTP felhasználó
    $mail->Password = "zWK8JTN]ARb6";                         // SMTP jelszó

    $mail->From = $sender;                  // Feladó e-mail címe  
    $mail->FromName = $senderName;              // Feladó neve
    $mail->CharSet = 'UTF-8';                              // the same as 'utf-8'
    $mail->AddAddress($to);                              // Címzett és neve

    $mail->WordWrap = 50;                                   // Sortörés állítása
    $mail->IsHTML(true);                                    // Küldés HTML-ként
    $mail->Subject = $subject;                  // A levél tárgya

    $mail->Body = $text;
    $mail->AltBody = $text;

    $mail->Send();
}

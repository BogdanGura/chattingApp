<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require __DIR__ .'\vendor\autoload.php';
 
    $mail = new PHPMailer(TRUE);

    //Setting up SMTP server
    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->Host = "smtp.example.com";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->Username = "admin-user@example.com";
    $mail->Password = "password";

    $mail->isHtml(true);
    return $mail;
 ?>
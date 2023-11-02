<?php

$email = $_POST['email'];

$token = bin2hex(random_bytes(16));

$token_hash = hash("sha256", $token);

//token will expire in 30 min
$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

//Run a config file
require_once 'config.php';

//Updating the table
//? are placeholders
$sql = "UPDATE users
        SET reset_password_token = ?,
            token_expiry = ?
        WHERE email = ?"; 

//Preperaring and executing the statement
$stmt = $db_link->prepare($sql);

$stmt->bind_param("sss", $token_hash, $expiry, $email);

$stmt->execute();

if($db_link->affected_rows)
{
    $mail = require_once __DIR__ . "\mailer.php";

    //Set the sender email
    $mail->setFrom("noreply@example.com");

    //Set the address to who to send
    $mail->addAddress($email);

    //Setting subject
    $mail->Subject = "Password Reset";

    //Body of an email
    $mail->Body = <<<END

    Click <a href="http://localhost/chatting-app/reset-password-form.php?token=$token">here</a>
    to reset your password.

    END;

    //Sending the email
    try{

        $mail->send();

    } catch (Exception $e)
    {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}<br>";
    }
}

echo "Message sent, please check your inbox <br>";
?>
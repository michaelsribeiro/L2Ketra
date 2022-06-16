<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "db_connect.php";

function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if(isset($_POST['email'])) {
    if(empty(validate($_POST['email']))) {
        $_SESSION['error'] = 'Insira seu e-mail!';
        header("Location: ../?pages=forgot");
        exit; 
    } else {
        $email = validate($_POST['email']);

        $sql_code = "SELECT * FROM accounts WHERE email = '$email'";
        $sql_exec = $mysqli->query($sql_code) or die($mysqli->error);

        if(mysqli_num_rows($sql_exec) > 0) {
            $fetch = $sql_exec->fetch_assoc();
            $key = sha1($fetch['password'], time());
            $email = $fetch['email'];
            sendEmail($email, $key);
        } else {
            $_SESSION['error'] = 'E-mail inválido!';
            header("Location: ../?pages=forgot");
            exit;
        }
    }
}

function sendEmail($email, $key) {

    require '../vendor/autoload.php';

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                     
        $mail->isSMTP();                                          
        $mail->Host       = 'smtp.sendgrid.net';                     
        $mail->SMTPAuth   = true;                                  
        $mail->Username   = 'apikey';                    
        $mail->Password   = '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';                          
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('michael-abd@live.com', 'Administrador');
        //$mail->addAddress( $email, 'Joe User');     //Add a recipient
        $mail->addAddress($email);

        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Primeiro E-mail de recuperação';
        $mail->Body    = 'Email de teste!';

        $mail->send();

        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message has not sent';
    }
}
?>
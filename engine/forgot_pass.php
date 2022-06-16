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
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.cloudmta.net';                     
        $mail->SMTPAuth   = true;                  
        $mail->Username   = '29edea731b2f948c';                    
        $mail->Password   = 'gD1fsSPFXdnHLjPLZea2KEhF';                             
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAutoTLS = true;           
        $mail->Port       = 587;

        $mail->setFrom('m.ribeiroabd@gmail.com', 'Admin');    
        $mail->addAddress($email); 

        $mail->isHTML(true);                                
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();

        $_SESSION['success'] = "Enviamos um e-mail para $email!";
        header("Location: ../?pages=forgot");
        exit;
    } catch(Exceprion $e) {
        $_SESSION['error'] = 'E-mail inválido!';
        header("Location: ../?pages=forgot");
        exit;
    }
}
?>
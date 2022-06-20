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
            $key = md5(uniqid($fetch['password'], time()));
            $_SESSION['account'] = $fetch['login'];               
            
            sendEmail($email, $key);              
            includeHash($email, $key);            
        } else {
            $_SESSION['error'] = 'E-mail inválido!';
            header("Location: ../?pages=forgot");
            exit;
        }
    }
}

function includeHash($email, $key, $mysqli) {
    $sql_code = "UPDATE accounts SET keycode = '$key' WHERE email = '$email'";
    $sql_exec = $mysqli->query($sql_code) or die($mysqli->$error);

    mysqli_affected_rows($mysqli) > 0 ? true : false;
}

function sendEmail($email, $key) {
    require '../vendor/autoload.php';

    $mail = new PHPMailer(true);

    try {
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.sendgrid.net';                     
        $mail->SMTPAuth   = true;                  
        $mail->Username   = 'apikey';                    
        $mail->Password   = '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';                             
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAutoTLS = true;           
        $mail->Port       = 587;

        $mail->setFrom('contato@lojaphoneshop.com.br', 'L2Ketra');    
        $mail->addAddress($email); 

        $mail->isHTML(true);                                
        $mail->Subject = "Recover your Account";
        $mail->Body    = "<html>
                            <body marginheight='0' topmargin='0' marginwidth='0' style='margin: 0px; background-color: #f2f3f8;' leftmargin='0'>
                            <!--100% body table-->
                            <table cellspacing='0' border='0' cellpadding='0' width='100%' bgcolor='#f2f3f8'
                                style='@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); 
                                    font-family: 'Open Sans', sans-serif;'>
                                <tr>
                                    <td>
                                        <table style='background-color: #f2f3f8; max-width:670px;  margin:0 auto;' width='100%' border='0'
                                            align='center' cellpadding='0' cellspacing='0'>
                                            <tr>
                                                <td style='height:80px;'>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style='text-align:center;'>
                                                    <a href='https://l2-ketra.herokuapp.com/' title='logo' target='_blank'>
                                                        <img width='260' src='https://i.ibb.co/7NK6MCn/logo-Ketra.png' alt='L2 Ketra'>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style='height:20px;'>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table width='95%' border='0' align='center' cellpadding='0' cellspacing='0'
                                                        style='max-width:670px;background:#fff; border-radius:3px; text-align:center;
                                                            -webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);
                                                            box-shadow:0 6px 18px 0 rgba(0,0,0,.06);'>
                                                        <tr>
                                                            <td style='height:40px;'>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td style='padding:0 25px;'>
                                                                <h1 style='color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:'Rubik',sans-serif;'>You have
                                                                    requested to reset your password</h1>
                                                                <span
                                                                    style='display:inline-block; vertical-align:middle; margin:26px 0; border-bottom:1px solid #cecece; width:100px;'></span>
                                                                <p style='color:#455056; font-size:15px;line-height:24px; margin:0;'>
                                                                    We cannot simply send you your old password. A unique link to reset your
                                                                    password has been generated for you. To reset your password, click the
                                                                    following link and follow the instructions.
                                                                </p>
                                                                <a href='https://l2-ketra.herokuapp.com/?pages=recoveracc&code={$key}' style='background:#20e277; 
                                                                    text-decoration:none !important; font-weight:500; margin-top:35px; color:#fff;text-transform:uppercase; 
                                                                    font-size:14px; padding:10px 24px; display:inline-block; border-radius:50px;'>Reset Password</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style='height:40px;'>&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            <tr>
                                                <td style='height:20px;'>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style='text-align:center;'>
                                                    <p style='font-size:14px; color:#333; line-height:18px; margin:0 0 0;'>&copy; <strong>L2 Ketra</strong></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style='height:80px;'>&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <!--/100% body table-->
                        </body>
                        </html>";

        $mail->send();
        $_SESSION['success'] = "Enviamos um e-mail para $email!";
        header("Location: ../?pages=forgot");
        exit;
    } catch(Exception $e) {
        $_SESSION['error'] = "E-mail inválido!";
        header("Location: ../?pages=forgot");
        exit;
    }
}
?>
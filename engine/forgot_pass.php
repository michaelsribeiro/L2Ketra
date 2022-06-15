<?php
session_start();

require_once "db_connect.php";

function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$email = '';

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
            sendEmail($email, $key);
        } else {
            $_SESSION['error'] = 'E-mail inválido!';
            header("Location: ../?pages=forgot");
            exit;
        }
    }
}

function sendEmail($email, $key) {
    $destination = $email;
    $subject = "L2 Ketra | Redefinição de Senha";
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $message = "<html><head>";
    $message .= "
            <body marginheight='0' topmargin='0' marginwidth='0' style='margin: 0px; background-color: #f2f3f8;' leftmargin='0'>
            <table cellspacing='0' border='0' cellpadding='0' width='100%' bgcolor='#f2f3f8'
                style='@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: 'Open Sans', sans-serif;'>
                <tr>
                    <td>
                        <table style='background-color: #f2f3f8; max-width:670px;  margin:0 auto;' width='100%' border='0'
                            align='center' cellpadding='0' cellspacing='0'>
                            <tr>
                                <td style='height:80px;'>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style='text-align:center;'>
                                <a href='https://rakeshmandal.com' title='logo' target='_blank'>
                                    <img width='60' src='https://i.ibb.co/hL4XZp2/android-chrome-192x192.png' title='logo' alt='logo'>
                                </a>
                                </td>
                            </tr>
                            <tr>
                                <td style='height:20px;'>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <table width='95%' border='0' align='center' cellpadding='0' cellspacing='0'
                                        style='max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);'>
                                        <tr>
                                            <td style='height:40px;'>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style='padding:0 35px;'>
                                                <h1 style='color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:'Rubik',sans-serif;'>You have
                                                    requested to reset your password</h1>
                                                <span
                                                    style='display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;'></span>
                                                <p style='color:#455056; font-size:15px;line-height:24px; margin:0;'>
                                                    We cannot simply send you your old password. A unique link to reset your
                                                    password has been generated for you. To reset your password, click the
                                                    following link and follow the instructions.
                                                </p>
                                                <a href='https://l2-ketra.herokuapp.com/?pages={$key}'
                                                    style='background:#20e277;text-decoration:none !important; font-weight:500; margin-top:35px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;'>Reset
                                                    Password</a>
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
                                    <p style='font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;'><strong>https://l2-ketra.herokuapp.com/</strong></p>
                                </td>
                            </tr>
                            <tr>
                                <td style='height:80px;'>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            </body>";
        $message .= "</head></html>";

        if(mail($destination, $subject, $message, $headers)){ 
            $_SESSION['success'] = "Enviamos um e-mail para $email";
            header("Location: ../?pages=forgot");
            exit;            
        } else {
            $_SESSION['error'] = 'Este campo é obrigatório!';
            header("Location: ../?pages=forgot");
            exit; 
        }
}



?>
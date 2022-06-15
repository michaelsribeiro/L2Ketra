<?php
session_start();

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
    $from = 'michael-abd@live.com';
    $to = $email;
    $subject = 'L2 Ketra | Redefinição de Senha';
    $message = 'Email de teste';
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $headers .= 'From: exemplo@exemplo.com' . "\r\n";
    $headers .= 'Reply-To: exemplo@exemplo.com' . "\r\n";    
    'X-Mailer: PHP/' . phpversion();

    $send = mail($to, $subject, $message, $headers);

    if ($send){
        $_SESSION['success'] = "Enviamos um e-mail para $email";
        header("Location: ../?pages=forgot");
        exit;  
    } else {
        $_SESSION['error'] = "Este campo é obrigatório";
        header("Location: ../?pages=forgot");
        exit;
    }

}
?>
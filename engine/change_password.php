<?php
session_start();

require_once "db_connect.php";

function validate($data) {
    trim($data);
    stripslashes($data);
    htmlspecialchars($data);
    return $data;
}

$login = $_SESSION['login'];
$curr_pass = '';
$newpass = '';
$confirm_newpass = '';

if(isset($_POST['pass'])) {
    if(empty(validate($_POST['pass']))) {
        $_SESSION['error'] = 'Insira a senha atual!';
        header("Location: ../?pages=panel_changepass");
        exit; 
    } else {
        $curr_pass = validate($_POST['pass']);
    }
}

if(isset($_POST['newpass'])) {
    if(empty(validate($_POST['newpass']))) {
        $_SESSION['error'] = 'Insira sua nova senha!';
        header("Location: ../?pages=panel_changepass");
        exit; 
    } else {
        $newpass = validate($_POST['newpass']);
    }
}

if(isset($_POST['newpass2'])) {
    if(empty(validate($_POST['newpass2']))) {
        $_SESSION['error'] = 'Confirme sua nova senha!';
        header("Location: ../?pages=panel_changepass");
        exit;
    } else {
        $confirm_newpass = validate($_POST['newpass2']);
    }
}

if($newpass != $confirm_newpass) {
    $_SESSION['error'] = 'As senhas não são iguais!';
    header("Location: ../?pages=panel_changepass");
    exit; 
}

if(!empty($curr_pass) && !empty($newpass) && !empty($confirm_newpass)) {

    $sql_code1 = "SELECT login, password FROM accounts WHERE login = '$login' LIMIT 1";
    $sql_exec1 = $mysqli->query($sql_code1) or die($mysqli->$error);
    $bd_password = $sql_exec1->fetch_assoc();    

    if(password_verify($curr_pass, $bd_password['password'])){
        $hashed_newpass = str_replace("$2y$", "$2a$", password_hash($newpass, PASSWORD_BCRYPT));
        $sql_code = "UPDATE accounts SET password = '$hashed_newpass' WHERE login = '$login' LIMIT 1";
        $sql_exec = $mysqli->query($sql_code) or die($mysqli->$error);

        $_SESSION['success'] = 'Senha atualizada com sucesso!';
        header("Location: ../?pages=panel_changepass");
        exit;
    } else {
        $_SESSION['error'] = 'Senha incorreta, tente novamente!';
        header("Location: ../?pages=panel_changepass");
        exit;
    }
}
?>
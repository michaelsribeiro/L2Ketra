<?php
session_start();

require_once "db_connect.php";

function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$login = $_SESSION['login'];
$newemail = '';
$confirm_newemail = '';

if(isset($_POST['newemail'])) {
    if(empty(validate($_POST['newemail']))) {
        $_SESSION['error'] = 'Insira seu novo email!';
        header("Location: ../?pages=panel_changeemail");
        exit; 
    } else {
        $newemail = validate($_POST['newemail']);
    }
}

if(isset($_POST['newemail2'])) {
    if(empty(validate($_POST['newemail2']))) {
        $_SESSION['error'] = 'Confirme seu novo email!';
        header("Location: ../?pages=panel_changeemail");
        exit;
    } else {
        $confirm_newemail = validate($_POST['newemail2']);
    }
}

if($newemail != $confirm_newemail) {
    $_SESSION['error'] = 'Emails não são iguais!';
    header("Location: ../?pages=panel_changeemail");
    exit; 
}

if(!empty($newemail) && !empty($confirm_newemail)) {  

    $sql_code = "UPDATE accounts SET email = '$newemail' WHERE login = '$login' LIMIT 1";
    $sql_exec = $mysqli->query($sql_code) or die($mysqli->$error);

    $_SESSION['success'] = 'Email atualizado com sucesso!';
    header("Location: ../?pages=panel_changeemail");
    exit;

}
?>
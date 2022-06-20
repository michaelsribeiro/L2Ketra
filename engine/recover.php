<?php
session_start();

require_once "db_connect.php";

function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$key = $_POST['key'];
$newpass = '';
$confirm_newpass = '';

if(isset($_POST['newpass'])) {
    if(empty(validate($_POST['newpass']))) {
        $_SESSION['error'] = "Insira sua nova senha!";
        header("Location: ../?pages=recoveracc&code={$key}");
        exit; 
    } else {
        $newpass = validate($_POST['newpass']);
    }
}

if(isset($_POST['newpass2'])) {
    if(empty(validate($_POST['newpass2']))) {
        $_SESSION['error'] = "Confirme sua nova senha!";
        header("Location: ../?pages=recoveracc&code={$key}");
        exit;
    } else {
        $confirm_newpass = validate($_POST['newpass2']);
    }
}

if($newpass != $confirm_newpass) {
    $_SESSION['error'] = "As senhas não são iguais!";
    header("Location: ../?pages=recoveracc&code={$key}");
    exit; 
}

if(!empty($newpass) && !empty($confirm_newpass)) {

    $sql_code1 = "SELECT login, password, keycode FROM accounts WHERE keycode = '$key'";
    $sql_exec1 = $mysqli->query($sql_code1) or die($mysqli->$error);
    $result = $sql_exec1->fetch_assoc();    

    if($result){
        $hashed_newpass = str_replace("$2y$", "$2a$", password_hash($newpass, PASSWORD_BCRYPT));
        $sql_code = "UPDATE accounts SET password = '$hashed_newpass' WHERE keycode = '$key'";
        $sql_exec = $mysqli->query($sql_code) or die($mysqli->$error);

        $_SESSION['success'] = "Senha alterada com sucesso!";
        header("Location: ../?pages=recoveracc&code={$key}");
        exit;
    } else {
        $_SESSION['error'] = "Senha incorreta, tente novamente!";
        header("Location: ../?pages=recoveracc&code={$key}");
        exit;
    }
}
?>
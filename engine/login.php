<?php
session_start();

require_once "db_connect.php";

function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}    

$login = validate($_POST['login']);
$password = validate($_POST['password']);

if(!empty($login) || !empty($password)) {

    $sql_code = "SELECT login, password FROM accounts WHERE login = '$login' LIMIT 1";
    $sql_exec = $mysqli->query($sql_code) or die($mysqli->$error);
    $hashed_password = $sql_exec->fetch_assoc();

    if(password_verify($password, $hashed_password['password'])){
        $sql = "INSERT INTO site_ucp_lastlogins (login, ip, logdate) VALUES ('".$login."', '".$_SERVER['REMOTE_ADDR']."', '".time()."')";
        $sql_exec = $mysqli->query($sql) or die($mysqli->$error);
        if(!$sql) { return false; }

        session_start();

        $_SESSION['loggedin'] = true;
        $_SESSION['login'] = $login;

        header('Location: ../?pages=home');
        exit;
    } else {
        $_SESSION['error-user'] = 'Login ou senha incorretos!';
        header("Location: ../?pages=home");
        exit; 
    }            
    
} else {
    
    $_SESSION['error-user'] = 'Preencha todos os campos!';
    header("Location: ../?pages=home");
    exit;            
} 



?>
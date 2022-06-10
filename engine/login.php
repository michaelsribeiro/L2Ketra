<?php
session_start();

require_once "db_connect.php";

function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$login = '';
$password = '';
$change = $_POST['change'];

if(isset($_POST['login'])) {
    if(empty(validate($_POST['login']))) {
        $_SESSION['error-user'] = "Insira seu login!";
    } else {
        $login = validate($_POST['login']);
    }
}

if(isset($_POST['password'])) {
    if(empty(validate($_POST['password']))) {
        $_SESSION['error-user'] = "Insira sua senha!";
    } else {
        $password = validate($_POST['password']);
    }
}

if(!empty($login) || !empty($password)) {

    $sql_code = "SELECT login, password, email FROM accounts WHERE login = '$login' LIMIT 1";
    $sql_exec = $mysqli->query($sql_code) or die($mysqli->$error);
    $hashed_password = $sql_exec->fetch_assoc();

    if(password_verify($password, $hashed_password['password'])){
        $sql = "INSERT INTO site_ucp_lastlogins (login, ip, logdate) VALUES ('".$login."', '".$_SERVER['REMOTE_ADDR']."', '".time()."')";
        $sql_exec = $mysqli->query($sql) or die($mysqli->$error);

        session_start();

        $_SESSION['loggedin'] = true;
        $_SESSION['login'] = $login;
        $_SESSION['email'] =  $hashed_password['email'];

        if(isset($change)){
            header("Location: ../?pages=changepass");
            exit; 
        } else {
            header("Location: ../?pages=home");
            exit; 
        }
    } else {

        if(isset($change)){
            $_SESSION['error'] = 'Login ou senha incorretos!';
            header("Location: ../?pages=changepass");
            exit; 
        } else {
            $_SESSION['error-user'] = 'Login ou senha incorretos!';
            header("Location: ../?pages=home");
            exit; 
        }
    }            
    
} else {    

    if(isset($change)){
        $_SESSION['error'] = 'Preencha todos os campos!';
        header("Location: ../?pages=changepass");
        exit; 
    } else {
        $_SESSION['error-user'] = 'Preencha todos os campos!';
        header("Location: ../?pages=home");
        exit; 
    }
               
} 



?>
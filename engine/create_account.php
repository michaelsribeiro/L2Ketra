<?php     
    session_start();

    if(isset($_POST['create'])) {
        include "db_connect.php";

        function validate($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $login = validate($_POST['login']);
        $password = validate($_POST['pass']);
        $confirmPass = validate($_POST['pass2']);
        $email = validate($_POST['email']);
        $confirmEmail = validate($_POST['email2']);
        $acceptRules = $_POST['checkbox'];

        $_SESSION['login'] = $login;
        $_SESSION['password'] = $password;
        $_SESSION['email'] = $email;

        if(empty($_SESSION['login']) || $_SESSION['email'] || $_SESSION['pass']) {

            $_SESSION['error'] = 'Preencha todos os campos';
            header("Location ./?pages=register");
            exit;

        }

        
    }
?>
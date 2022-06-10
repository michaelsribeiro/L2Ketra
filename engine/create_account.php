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

        if(empty($acceptRules)) {
            $_SESSION['error'] = 'Para se cadastrar é preciso concordar com as regras!';
            header("Location: ../?pages=register");
            exit;
        }

        if(!empty($_SESSION['login']) && !empty($_SESSION['password']) && !empty($_SESSION['email'])) {

            if($password == $confirmPass) {
                
                if($email == $confirmEmail){

                    checkLoginExists($login);
                    checkEmailExists($email);

                    $password = str_replace("$2y$", "$2a$", password_hash($password, PASSWORD_BCRYPT));
                    $sql = "INSERT INTO accounts (login, password, email) VALUES('$login', '$password', '$email')";
                    $result = mysqli_query($mysqli, $sql);
    
                    if($result) {
                        $_SESSION['success'] = 'Cadastro realizado com sucesso!';
                        header("Location: ../?pages=register");
                        exit;
                    } else {
                        $_SESSION['error'] = 'Unknown error occurred!';
                        header("Location: ../?pages=register");
                        exit;
                    }
                } else {
                    $_SESSION['error'] = 'Emails não coincidem';
                    header("Location: ../?pages=register");
                    exit;
                }
            } else {
                $_SESSION['error'] = 'Senhas não conicidem';
                header("Location: ../?pages=register");
                exit;               
            }

        } else {
            $_SESSION['error'] = 'Preencha todos os campos!';
            header("Location: ../?pages=register");
            exit;    
        }

        if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email)) {
            $_SESSION['error'] = 'Email só pode conter letras e números!';
            header("Location: ../?pages=register");
            exit; 
        }        
    }

    function checkEmailExists($email) {
        include "db_connect.php";

        $sql = "SELECT login, email FROM accounts WHERE email = '$email'";
        $result = mysqli_query($mysqli, $sql);

        if(mysqli_num_rows($result) > 0) {
            $fetch_query = mysqli_fetch_assoc($result);
            if($fetch_query['email'] == $email) {
                $_SESSION['error'] = 'Este email já está em uso!';
                header("Location: ../?pages=register");
                exit; 
            }
        }
    }

    function checkLoginExists($login) {
        include "db_connect.php";

        $sql = "SELECT * FROM accounts WHERE login = '$login' LIMIT 1";
        $result = mysqli_query($mysqli, $sql);

        if(mysqli_num_rows($result) > 0) {
            $fetch_query = mysqli_fetch_assoc($result);
            if($fetch_query['login'] == $login) {
                $_SESSION['error'] = 'Este login já está em uso!';
                header("Location: ../?pages=register");
                exit; 
            }
        }
    }
?>
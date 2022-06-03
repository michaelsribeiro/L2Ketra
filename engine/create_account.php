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

        var_dump($_POST);

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
                    $sql = "INSERT INTO accounts(login, password, email) VALUES('$login', '$password', '$email')";
                    $result = mysqli_query($conn, $sql);
                    print_r($result);
    
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

        
    }
?>
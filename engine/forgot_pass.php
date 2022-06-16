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
    /*$from = 'michael-abd@live.com';
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
    }*/

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $_ENV['l2-ketra.herokuapp.com'] . "/api/i/v1/email",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>"{\"recipients\":[{\"email\":\"contato@lojaphoneshop.com.br\"}],\"title\":\"Title\",\"html\":\"Body\"}",
        CURLOPT_HTTPHEADER => array(
            "x-trustifi-key: " . $_ENV['fff7f662051f68935dbf6fed0c4d45189460f5c49ec0ba18'],
            "x-trustifi-secret: " . $_ENV['0a3bd21e016f6d1b3fd6961f949534f4'],
            "content-type: application/json"
        )
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }

}
?>
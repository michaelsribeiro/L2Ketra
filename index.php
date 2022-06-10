<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>L2 Ketra - Interlude</title>

    <!-- FAVICON -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>
    <?php
        session_start(); 
        include "pages/header.php";
        require_once "engine/db_connect.php"; ?>
    <section>
        <div class="container page">
            <?php             

                $rota = $_GET['pages'] ?? 'home';

                file_exists("pages/{$rota}.php") ? require_once "pages/{$rota}.php" : require_once "pages/404.php";
               
            ?>
        </div>
    </section>
    <?php include "pages/footer.php"?>
<script type="text/javascript" src="assets/js/app.js"></script>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v13.0" nonce="0SrYOoyX"></script>
</body>
</html>

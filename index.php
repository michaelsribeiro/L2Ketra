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
    <?php include "pages/header.php" ?>
    <section>
        <div class="container page">
            <?php 
                if(isset($_GET['pages'])) {
                    require_once "pages/".$_GET['pages'].".php"; 
                }            
            ?>
        </div>
    </section>
    <?php include "pages/footer.php"?>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v13.0" nonce="0SrYOoyX"></script>
</body>
</html>

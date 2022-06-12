<?php
    if(isset($_SESSION['loggedin'])){
        header('Location: ?pages=panel_changepass');
        exit;
    }
?>
<div class="account-manager">
    <h1>Forgot Password</h1>
    <div class="menu-nav">
        <a href="?pages=register">Register</a>
        <a href="?pages=changepass">Change Password</a>
        <a href="?pages=forgot" class="active">Recover</a>
    </div>
    
    <form action="engine/forgot_pass.php" method="POST" class="registerForm">
        <p class="info">Forgot your password? Type in the box below the e-mail you used to register the account. Send you instructions on how to recover.</p>
        <div class="dual-column">
            <?php
                if($_SESSION['error']){
                    echo '<span class="msg danger">'.$_SESSION['error'].'</span>';
                    $_SESSION['error'] = '';
                } else if($_SESSION['success']){
                    echo '<span class="msg success">'.$_SESSION['success'].'</span>';
                    $_SESSION['success'] = '';
                }
            ?>
            <label class="formpadrao">
                <div class="input-area">
                    <div class="desc">Email:</div>
                    <div class="camp">
                        <input type="email" name="email" id="email" maxlenght="100" autocomplete="off">
                    </div>
                </div>
            </label>
        </div>
        <input type="submit" class="btn-default" value="Recover" name="recover">
    </form>  
</div>


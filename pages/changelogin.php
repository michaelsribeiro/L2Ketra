<?php?>
<form action="engine/login.php" method="POST" class="registerForm">
    <span class="msg-reg danger">To change password, login is required.</span>
    <div class="dual-column">
        <?php
            if($_SESSION['error-user']){
            echo '<span class="msg-reg danger">'.$_SESSION['error'].'</span>';
            $_SESSION['error'] = '';
        } 
        ?>
        <label class="formpadrao">
            <div class="input-area">
                <div class="desc">Login:</div>
                <div class="camp">
                    <input type="text" name="login" id="login" maxlenght="14" autocomplete="off">
                </div>
            </div>
        </label>
        <label class="formpadrao">
            <div class="input-area">
                <div class="desc">Current Password:</div>
                <div class="camp">
                    <input type="password" name="password" id="pass" minlenght="6" maxlenght="25" autocomplete="off">
                </div>
            </div>
        </label>
        <input type="submit" class="btn-default" value="Login">                    
    </div>
</form>
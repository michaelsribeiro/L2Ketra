<div class="account-manager">
    <h1>Change Password</h1>
    <div class="menu-nav">
        <a href="?pages=register">Register</a>
        <a href="?pages=changepass" class="active">Change Password</a>
        <a href="?pages=forgot">Recover</a>
    </div>    
    <form action="engine/login.php" method="POST" class="registerForm">
        <span class="msg danger">To change password, login is required.</span>
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
                        <input type="password" name="pass" id="pass" minlenght="6" maxlenght="25" autocomplete="off">
                    </div>
                </div>
            </label>            
        </div>
        <input type="submit" class="btn-default" value="Login" name="login">
    </form>  
</div>

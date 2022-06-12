<?php
    if(!isset($_SESSION['loggedin'])){
        header('Location: ?pages=changepass');
        exit;
    }
?>
<div class="account-manager">
    <h1>Change E-mail</h1>
    <div class="menu-nav">
        <a href="?pages=changepass">Change Password</a>
        <a href="?pages=panel_changeemail" class="active">Change Email</a>
    </div>    
    <form action="engine/change_email.php" method="POST" class="registerForm">
        <div class="dual-column">
            <?php
                if($_SESSION['error']){
                    echo '<span class="msg-reg danger">'.$_SESSION['error'].'</span>';
                    $_SESSION['error'] = '';
                } else if($_SESSION['success']){
                    echo '<span class="msg-reg success">'.$_SESSION['success'].'</span>';
                    $_SESSION['success'] = '';
                }
            ?>
            <label class="formpadrao">
                <div class="input-area">
                    <div class="desc">Login:</div>
                    <div class="camp">
                        <input type="text" name="login" id="login" maxlenght="14" autocomplete="off" disabled value="<?php echo $_SESSION['login'] ?>">
                    </div>
                </div>
            </label>
            <label class="formpadrao">
                <div class="input-area">
                    <div class="desc">Current E-mail:</div>
                    <div class="camp">
                        <input type="email" name="email" id="email" maxlenght="100" autocomplete="off" disabled value="<?php echo $_SESSION['email'] ?>">
                    </div>
                </div>
            </label>
            <label class="formpadrao">
                <div class="input-area">
                    <div class="desc">New E-mail:</div>
                    <div class="camp">
                        <input type="email" name="newemail" id="email" maxlenght="100" autocomplete="off">
                    </div>
                </div>
            </label>
            <label class="formpadrao">
                <div class="input-area">
                    <div class="desc">Repeat E-mail:</div>
                    <div class="camp">
                        <input type="email" name="newemail2" id="email" maxlenght="100" autocomplete="off">
                    </div>
                </div>
            </label>
        </div>
        <input type="submit" class="btn-default" value="Change Email">
    </form>  
</div>


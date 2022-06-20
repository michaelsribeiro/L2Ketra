<?php $key = $_GET['code']; ?>
<div class="account-manager">
    <h1>Recover Account</h1>   
    <form action="engine/recover.php" method="POST" class="registerForm">
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
                        <input type="text" name="login" id="login" maxlenght="14" autocomplete="off" disabled value="<?php echo $_SESSION['account'] ?>">
                    </div>
                </div>
            </label>
            <label class="formpadrao">
                <div class="input-area">
                    <div class="desc">New Password:</div>
                    <div class="camp">
                        <input type="password" name="newpass" id="pass" minlenght="6" maxlenght="25" autocomplete="off">
                    </div>
                </div>
            </label>            
            <label class="formpadrao">
                <div class="input-area">
                    <div class="desc">Repeat Password:</div>
                    <div class="camp">
                        <input type="password" name="newpass2" id="pass" minlenght="6" maxlenght="25" autocomplete="off">
                    </div>
                </div>
            </label>
        </div>
        <input type="submit" class="btn-default" value="Change Password">
        <input type="hidden" value="<?=$key?>">
    </form>  
</div>


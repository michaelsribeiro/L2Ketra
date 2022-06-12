<?php
    if(isset($_SESSION['loggedin'])){
        header('Location: ?pages=panel_changepass');
        exit;
    }
?>
<div class="account-manager">
    <h1>Register Account</h1>
    <div class="menu-nav">
        <a href="?pages=register" class="active">Register</a>
        <a href="?pages=changepass">Change Password</a>
        <a href="?pages=forgot">Recover</a>
    </div>
    <div class="inner">
        <div class="rules">
            <h1>Rules</h1>
            <div class="rules-text">
                <p>01. Always treat all Administrators, Game Masters and members of management with respect. Any act of disrespect to the administration, regardless of the medium, result in punishment.</p>
                <p>02. It is forbidden to impersonate (pretend to be) any member of the administration.</p>
                <p>03. Advertising, comments or suggestions of any other Lineage server is prohibited in any game chat or other media connected to us.</p>
                <p>04. It is forbidden to use programs that interact with the Lineage 2, exploits or take advantage of any problems found in the game, in the forum or website that will benefit you in relation to other players. If a player finds a bug (problem/fault) in the game, forum or site shall immediately inform the administration.</p>
                <p>05. Never ask levels, items, adena, teleport or any benefit to any member of the administration because you will not be answered.</p>
                <p>06. Your account is not transferable, it means that you are responsible for your own safety in the game. Never give your password to anyone else, including the administration. Make sure that the computer used to play it safe. Never run extra interactivity programs with your Lineage 2, which was not provided by management, as they may contain viruses and keyloguers that will result in the theft of your user accounts and / or items. The administration is not responsible for any theft, dropped or destroyed items. The administration ensures complete integrity and server security and therefore are not possible invasions hacks to steal items or accounts directly on the server, site or forum, in other words, any type of theft are caused by carelessness or misuse of users.</p>
                <p>07. All user data (its accuracy and maintenance) are the sole responsibility of the user. Take care of your data and keep your active e-mail account it is necessary to recover your password if you forget it. The administration is not responsible for data forgotten, lost, deleted or canceled for any reason.</p>
                <p>08. It is forbidden to offend other players with profanity, derogatory and offensive names, pornographic offenses, racist and others in Global Chat and any other media provided by our team. In in-game chats use the command /block for not to read unwanted messages. Use the hero chat with wisdom because it involves reading the entire server. Also the use of any chat to incite or manipulate the players the server against the administration is prohibited.</p>
                <p>09. Players who accuse without evidence the administration will be severely punished. The administration will not allow bad players tarnish the image of the server because they are bad losers.</p>
                <p>10. Any action in the game that the administration deems anti-gambling (actions considered inappropriate or bad character) will also result in penalties such as: losing on purpose in the Grand Olympiad to give points to another character; disrupt or attempt to deceive in any way automatic events or made by management; Try to fool other players offering false items.</p>
            </div>
        </div>
    </div>
    <form action="engine/create_account.php" method="POST" class="registerForm">
        <label class="msg-reg warn">
            <input type="checkbox" id="acceptRules" value="1" name="checkbox">
            <strong>I accept all the rules</strong>
        </label>
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
                    <div class="desc">* Login:</div>
                    <div class="camp">
                        <input type="text" name="login" id="login" maxlenght="14" autocomplete="off">
                    </div>
                </div>
            </label>
            <label class="formpadrao">
                <div class="input-area">
                    <div class="desc">* Password:</div>
                    <div class="camp">
                        <input type="password" name="pass" id="pass" minlenght="6" maxlenght="25" autocomplete="off">
                    </div>
                </div>
            </label>
            <label class="formpadrao">
                <div class="input-area">
                    <div class="desc">* Repeat Password:</div>
                    <div class="camp">
                        <input type="password" name="pass2" id="pass" minlenght="6" maxlenght="25" autocomplete="off">
                    </div>
                </div>
            </label>
            <label class="formpadrao">
                <div class="input-area">
                    <div class="desc">* Email:</div>
                    <div class="camp">
                        <input type="email" name="email" id="email" maxlenght="100" autocomplete="off">
                    </div>
                </div>
            </label>
            <label class="formpadrao">
                <div class="input-area">
                    <div class="desc">* Repeat Email:</div>
                    <div class="camp">
                        <input type="email" name="email2" id="email" maxlenght="100" autocomplete="off">
                    </div>
                </div>
            </label>
        </div>
        <input type="submit" class="btn-default" value="Register" name="create">
    </form>  
</div>


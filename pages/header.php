<?php require_once "engine/db_connect.php"; ?>
<header>
    <div class="container">
        <div class="user">
            <?php
                if($_SESSION['error-user']){
                    echo '<span class="msg danger">'.$_SESSION['error-user'].'</span>';
                    $_SESSION['error-user'] = '';
                }
            ?>
             <?php echo "<div ".(isset($_SESSION['loggedin']) === true ? "class='loginarea logged'" : "class='loginarea'").">"?>
                <a href="engine/logout.php" class="close" display="none"></a>
                <span class="username"><?php echo isset($_SESSION['login']) ? strtoupper($_SESSION['login']) : ''; ?></span>
                <form action="engine/login.php" method="POST">
                    <div class="formarea">
                        
                        <label>
                            <input type="text" name="login" id="login" class="input" title="Username" autocomplete="off" placeholder="Login">
                            <div class="user-icon user"></div>
                        </label>
                        <label>
                            <input type="password" name="password" id="pass" class="input" title="Password" autocomplete="off" placeholder="Password">
                            <div class="user-icon pass"></div>
                        </label>                            
                    </div>                       
                    <div class="box-btn">
                        <input class="submit-btn" type="submit" value=" ">
                    </div>
                </form>
                <div class="forgot"><a href="./?pages=forgot">Forgot your password?</a></div>
            </div>            
            <?php echo "<img class='avatar' src='assets/images/".(isset($_SESSION['loggedin']) === true ? "female-elf.jpg" : "dark-elf-male.jpg")."'></img>"?>
            
        </div>
        <div class="serverStatus">
            <span></span>
            <p>Server Online</p>
            <?php
                $sql_code = "SELECT COUNT(*) AS quant FROM characters WHERE online > 0";
                $sql_exec = $mysqli->query($sql_code) or die($mysqli->$error);

                if(mysqli_num_rows($sql_exec) > 0) {
                    while($row = $sql_exec->fetch_assoc()){
                        echo "<div class='players_on'>".$row['quant']."</div>";
                    }
                }
            ?>            
        </div>
        <nav>
            <ul>
                <a href="?pages=home"><li class="op-1"></li></a>
                <a href="?pages=server"><li class="op-2"></li></a>
                <a href="?pages=download"><li class="op-3"></li></a>
                <a href="?pages=register"><li class="op-4"></li></a>
                <a href="?pages=toppvp"><li class="op-5"></li></a>
                <a href="?pages=donation"><li class="op-6"></li></a>
            </ul>
        </nav>
    </div>
</header>
<section class="statsbox">
    <div class="container stats">
        <div class="results">
            <div class="box-rank">
                <div class="title">
                    <span class="pvp"></span>
                    <div class="desc">Top Pvp</div>
                    <a href="./?pages=toppvp">view more »</a>
                </div>
                <?php
                $i = 0;
                $sql_code = "SELECT 
                            c.char_name, 
                            c.pvpkills
                        FROM 
                            characters as c 
                        WHERE 
                            c.accesslevel = 0 
                        ORDER BY pvpkills DESC, char_name ASC LIMIT 3";
                $sql_exec = $mysqli->query($sql_code) or die($mysqli->$error);

                if(mysqli_num_rows($sql_exec) > 0) {
                    while($row = $sql_exec->fetch_assoc()){
                        $i++;

                        echo"<div class='rank'>
                                <div class='p".$i." pos'>".$i."</div>
                                <div class='nickname'>".$row['char_name']."</div>
                                <div class='total'>".$row['pvpkills']."</div>
                            </div>";
                    }
                }
            ?>               
            </div>
            <div class="box-rank">
                <div class="title">
                    <span class="pk"></span>
                    <div class="desc">Top Pk</div>
                    <a href="./?pages=toppk">view more »</a>
                </div>
                <?php
                $i = 0;
                $sql_code = "SELECT 
                            c.char_name, 
                            c.pkkills 
                        FROM 
                            characters as c 
                        WHERE 
                            c.accesslevel = 0 
                        ORDER BY pkkills DESC, char_name ASC LIMIT 3";
                $sql_exec = $mysqli->query($sql_code) or die($mysqli->$error);

                if(mysqli_num_rows($sql_exec) > 0) {
                    while($row = $sql_exec->fetch_assoc()){
                        $i++;
                        echo"<div class='rank'>
                                <div class='p".$i." pos'>".$i."</div>
                                <div class='nickname'>".$row['char_name']."</div>
                                <div class='total'>".$row['pkkills']."</div>
                            </div>";
                    }
                }
                ?>
            </div>
            <div class="box-rank">
                <div class="title">
                    <span class="clan"></span>
                    <div class="desc">Top Clan</div>
                    <a href="./?pages=topclan">view more »</a>
                </div>
                <?php
                $i = 0;
                $sql_code = "SELECT 
                            c.clan_name, 
                            c.reputation_score 
                        FROM 
                            clan_data AS c 
                        ORDER BY c.clan_level DESC, c.reputation_score DESC LIMIT 3";
                $sql_exec = $mysqli->query($sql_code) or die($mysqli->$error);

                if(mysqli_num_rows($sql_exec) > 0) {
                    while($row = $sql_exec->fetch_assoc()){
                        $i++;
                        echo"<div class='rank'>
                            <div class='p".$i." pos'>".$i."</div>
                            <div class='nickname'>".$row['clan_name']."</div>
                            <div class='total'>".$row['reputation_score']."</div>
                        </div>";
                    }
                }
                ?>    
            </div>
            <div class="box-rank">
                <div class="title">
                    <span class="online"></span>
                    <div class="desc">Top Online</div>
                    <a href="./?pages=toppvp">view more »</a>
                </div>
                <?php
                $i = 0;
                $sql_code = "SELECT 
                            c.char_name, 
                            c.onlinetime
                        FROM 
                            characters as c 
                        WHERE 
                            c.accesslevel = 0 
                        ORDER BY onlinetime DESC, char_name ASC LIMIT 3";
                $sql_exec = $mysqli->query($sql_code) or die($mysqli->$error);

                if(mysqli_num_rows($sql_exec) > 0) {
                    while($row = $sql_exec->fetch_assoc()){
                        $i++;

                        $dias = intval($row['onlinetime'] / 86400);
                        $marcador = $row['onlinetime'] % 86400; 
                        $hora = intval($marcador / 3600);
                        $marcador = $marcador % 3600; 
                        $minuto = intval($marcador / 60);

                        echo"<div class='rank'>
                                <div class='p".$i." pos'>".$i."</div>
                                <div class='nickname'>".$row['char_name']."</div>
                                <div class='total'>".$dias."d, ", $hora."h "."</div>
                            </div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>
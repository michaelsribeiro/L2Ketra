<?php include "engine/db_connect.php"; ?>
<header>
    <div class="container">
        <div class="user">
            <div class="loginarea">
                <form action="" method="POST">
                    <div class="formarea">
                        <label>
                            <input type="text" name="login" id="login" class="input" title="Username" autocomplete="off" placeholder="Login">
                            <div class="user-icon user"></div>
                        </label>
                        <label>
                            <input type="password" name="pass" id="pass" class="input" title="Password" autocomplete="off" placeholder="Password">
                            <div class="user-icon pass"></div>
                        </label>                            
                    </div>                       
                    <div class="box-btn">
                        <input class="submit-btn" type="submit" value=" " name="login">
                    </div>
                </form>
            </div>
            <div class="forgot"><a href="./?pages=forgot">Forgot your password?</a></div>
            <img class="avatar" src="assets/images/dark-elf-male.jpg"></img>
        </div>
        <div class="serverStatus">
            <span></span>
            <p>Server Online</p>
            <?php
                $sql = "SELECT COUNT(*) AS quant FROM characters WHERE online > 0";
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) > 0) {
                    $fetch = mysqli_fetch_assoc($result);

                    echo "<div class='players_on'>".$fetch['quant']."</div>";
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
                $sql = "SELECT 
                            c.char_name, 
                            c.pvpkills
                        FROM 
                            characters as c 
                        WHERE 
                            c.accesslevel = 0 
                        ORDER BY pvpkills DESC, char_name ASC LIMIT 3";
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) > 0) {
                    while($fetch = mysqli_fetch_assoc($result)){
                        $i++;
                         echo 
                         "<div class='rank'>
                            <div class='p".$i." pos'>".$i."</div>
                            <div class='nickname'>".$fetch['char_name']."</div>
                            <div class='total'>".$fetch['pvpkills']."</div>
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
                $sql = "SELECT 
                            c.char_name, 
                            c.pkkills 
                        FROM 
                            characters as c 
                        WHERE 
                            c.accesslevel = 0 
                        ORDER BY pkkills DESC, char_name ASC LIMIT 3";
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) > 0) {
                    while($fetch = mysqli_fetch_assoc($result)){
                        $i++;
                        echo 
                        "<div class='rank'>
                            <div class='p".$i." pos'>".$i."</div>
                            <div class='nickname'>".$fetch['char_name']."</div>
                            <div class='total'>".$fetch['pkkills']."</div>
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
                $sql = "SELECT 
                            c.clan_name, 
                            c.reputation_score 
                        FROM 
                            clan_data AS c 
                        ORDER BY c.clan_level DESC, c.reputation_score DESC LIMIT 3";
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) > 0) {
                    while($fetch = mysqli_fetch_assoc($result)){
                        $i++;
                         echo 
                         "<div class='rank'>
                            <div class='p".$i." pos'>".$i."</div>
                            <div class='nickname'>".$fetch['clan_name']."</div>
                            <div class='total'>".$fetch['reputation_score']."</div>
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
                $sql = "SELECT 
                            c.char_name, 
                            c.onlinetime
                        FROM 
                            characters as c 
                        WHERE 
                            c.accesslevel = 0 
                        ORDER BY onlinetime DESC, char_name ASC LIMIT 3";
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) > 0) {
                    while($fetch = mysqli_fetch_assoc($result)){
                        $i++;

                        $dias = intval($fetch['onlinetime'] / 86400);
                        $marcador = $fetch['onlinetime'] % 86400; 
                        $hora = intval($marcador / 3600);
                        $marcador = $marcador % 3600; 
                        $minuto = intval($marcador / 60);

                        echo 
                        "<div class='rank'>
                            <div class='p".$i." pos'>".$i."</div>
                            <div class='nickname'>".$fetch['char_name']."</div>
                            <div class='total'>".$dias."d, ", $hora."h "."</div>
                        </div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>
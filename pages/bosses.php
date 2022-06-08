<?php include "engine/db_connect.php"; ?>
<div class="ranking">
    <div class="rank-opt">
        <h1>Boss Status</h1>
        <div class="rank-nav">
            <a href="./?pages=toppvp">Top PvP</a>
            <a href="./?pages=toppk" >Top Pk</a>
            <a href="./?pages=topclan">Top Clan</a>
            <a href="./?pages=bosses" class="active">Boss Status</a>
            <a href="./?pages=sieges">Castle & Siege</a>
        </div>
    </div>

    <h2 style="align-self: start !important; font-size: 1.6rem !important; margin-left: 20px; margin-bottom: 20px !important;">Epic Bosses</h2>

    <table cellspacing="0" cellpadding="0" border="0" class="table">
        <thead>
            <tr>
            <th scope="col">NAME</th>
            <th scope="col">LEVEL</th>
            <th scope="col">STATUS</th>
            <th scope="col">RESPOWN</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i = 0;
                $sql = mysqli_query($conn, "SELECT b.boss_id, b.respawn_time AS respawn, c.name, c.level FROM grandboss_data AS b JOIN site_bosses AS c ON c.id = b.boss_id ORDER BY respawn DESC, level DESC, name ASC");
                if(mysqli_num_rows($sql) > 0) {
                    while($fetch = mysqli_fetch_assoc($sql)){
                        $i++;
                        
                        $fetch['respawn'] = (strlen($fetch['respawn']) > 11 ? ($fetch['respawn']/1000) : $fetch['respawn']);
                        if($fetch['respawn'] > time()) {
                            $respawn = date('d/m/Y H:i', $fetch['respawn']);
                            $status = 'Dead';
                        } else {
                            $status = 'Alive';
                            $respawn = '-';
                        }


                         echo 
                         "<tr".(($i % 2 == 0) ? " class='row-dark'" : "").">
                            <td>".$fetch['name']."</td>
                            <td>".$fetch['level']."</td>
                            <td".($status == 'Alive' ? " class='alive'" : " class='dead'").">".$status."</td>
                            <td>".$respawn."</td>
                        </tr>";
                    }
                }
            ?>             
        </tbody>
    </table>

    <h2 style="align-self: start !important; font-size: 1.6rem !important; margin: 50px 0 20px 20px">Raid Bosses</h2>

    <table cellspacing="0" cellpadding="0" border="0" class="table">
        <thead>
            <tr>
            <th scope="col">NAME</th>
            <th scope="col">LEVEL</th>
            <th scope="col">STATUS</th>
            <th scope="col">RESPOWN</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i = 0;
                $sql = mysqli_query($conn, "SELECT b.boss_id, b.respawn_time AS respawn, c.name, c.level FROM raidboss_spawnlist AS b JOIN site_bosses AS c ON c.id = b.boss_id ORDER BY respawn DESC, level DESC, name ASC");
                if(mysqli_num_rows($sql) > 0) {
                    while($fetch = mysqli_fetch_assoc($sql)){
                        $i++;
                        
                        $fetch['respawn'] = (strlen($fetch['respawn']) > 11 ? ($fetch['respawn']/1000) : $fetch['respawn']);
                        if($fetch['respawn'] > time()) {
                            $respawn = date('d/m/Y H:i', $fetch['respawn']);
                            $status = 'Dead';
                        } else {
                            $status = 'Alive';
                            $respawn = '-';
                        }


                         echo 
                         "<tr".(($i % 2 == 0) ? " class='row-dark'" : "").">
                            <td>".$fetch['name']."</td>
                            <td>".$fetch['level']."</td>
                            <td".($status == 'Alive' ? " class='alive'" : " class='dead'").">".$status."</td>
                            <td>".$respawn."</td>
                        </tr>";
                    }
                }
            ?>             
        </tbody>
    </table>
</div>
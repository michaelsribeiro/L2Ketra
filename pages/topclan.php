<?php include "engine/db_connect.php"; ?>
<div class="ranking">
    <div class="rank-opt">
        <h1>Top Clan</h1>
        <div class="rank-nav">
            <a href="./?pages=toppvp">Top PvP</a>
            <a href="./?pages=toppk" >Top Pk</a>
            <a href="./?pages=topclan" class="active">Top Clan</a>
            <a href="./?pages=oly">Olympiad</a>
            <a href="./?pages=bosses">Boss Status</a>
            <a href="./?pages=sieges">Castle & Siege</a>
        </div>
    </div>
    <table cellspacing="0" cellpadding="0" border="0" class="table">
        <thead>
            <tr>
            <th scope="col"></th>
            <th scope="col">NAME</th>
            <th scope="col">LEADER</th>
            <th scope="col">MEMBERS</th>
            <th scope="col">ALLY</th>
            <th scope="col">LEVEL</th>
            <th scope="col">REPUTATION</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i = 0;
                $sql = mysqli_query($conn, "SELECT c.clan_name, c.clan_level, c.reputation_score, c.ally_name, d.char_name, (SELECT COUNT(*) FROM characters WHERE clanid = c.clan_id) AS membros FROM clan_data AS c LEFT JOIN characters AS d ON d.obj_Id = c.leader_id ORDER BY c.clan_level DESC, c.reputation_score DESC, membros DESC LIMIT 10");
                if(mysqli_num_rows($sql) > 0) {
                    while($fetch = mysqli_fetch_assoc($sql)){
                        $i++;
                         echo 
                         "<tr".(($i % 2 == 0) ? " class='row-dark'" : "").">
                            <td class='pos'>".$i."</td>
                            <td class='name-strong'>".$fetch['clan_name']."</td>
                            <td>".$fetch['char_name']."</td>
                            <td>".$fetch['membros']."</td>
                            <td>".$fetch['ally_name']."</td>
                            <td>".$fetch['clan_level']."</td>
                            <td>".$fetch['reputation_score']."</td>
                        </tr>";
                    }
                }
            ?>             
        </tbody>
    </table>
</div>
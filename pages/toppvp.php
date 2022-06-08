<?php include "engine/db_connect.php"; ?>
<div class="ranking">
    <div class="rank-opt">
        <h1>Top PvP</h1>
        <div class="rank-nav">
            <a href="./?pages=toppvp" class="active">Top PvP</a>
            <a href="./?pages=toppk">Top Pk</a>
            <a href="./?pages=topclan">Top Clan</a>
            <a href="./?pages=bosses">Boss Status</a>
            <a href="./?pages=sieges">Castle & Siege</a>
        </div>
    </div>
    <table cellspacing="0" cellpadding="0" border="0" class="table">
        <thead>
            <tr>
            <th scope="col"></th>
            <th scope="col">NAME</th>
            <th scope="col">CLAN</th>
            <th scope="col">ALLY</th>
            <th scope="col">PVP'S</th>
            <th scope="col">PK'S</th>
            <th scope="col">TIME</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i = 0;
                $sql =  mysqli_query($conn, "SELECT c.char_name, c.pvpkills, c.pkkills, c.online, c.onlinetime, d.clan_name FROM characters as c LEFT JOIN clan_data as d ON c.clanid = d.clan_id WHERE c.accesslevel = 0 ORDER BY pvpkills DESC, pkkills DESC, onlinetime DESC, char_name ASC LIMIT 20");
                if(mysqli_num_rows($sql) > 0) {
                    while($fetch = mysqli_fetch_assoc($sql)){
                        $i++;
                         echo 
                         "<tr".(($i % 2 == 0) ? " class='row-dark'" : "").">
                            <td class='pos'>".$i."</td>
                            <td class='name-strong'>".$fetch['char_name']."</td>
                            <td>".(empty($fetch['clan_name']) ? '-' : $fetch['clan_name'])."</td>
                            <td>-</td>
                            <td class='pvp'>".$fetch['pvpkills']."</td>
                            <td class='pk'>".$fetch['pkkills']."</td>
                            <td>".$fetch['onlinetime']."</td>
                        </tr>";
                    }
                }
            ?>             
        </tbody>
    </table>
</div>
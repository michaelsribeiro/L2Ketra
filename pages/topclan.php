<?php  ?>
<div class="ranking">
    <div class="rank-opt">
        <h1>Top Clan</h1>
        <div class="rank-nav">
            <a href="./?pages=toppvp">Top PvP</a>
            <a href="./?pages=toppk" >Top Pk</a>
            <a href="./?pages=topclan" class="active">Top Clan</a>
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
                $sql_code = "SELECT 
                            c.clan_name, 
                            c.clan_level, 
                            c.reputation_score, 
                            c.ally_name, 
                            d.char_name, 
                            (SELECT COUNT(*) FROM characters WHERE clanid = c.clan_id) AS membros 
                        FROM 
                            clan_data AS c 
                        LEFT JOIN 
                            characters AS d ON d.obj_Id = c.leader_id 
                        ORDER BY c.clan_level DESC, c.reputation_score DESC, membros DESC LIMIT 10";
                 $sql_exec = $mysqli->query($sql_code) or die($mysqli->$error);

                 if(mysqli_num_rows($sql_exec) > 0) {
                     while($row = $sql_exec->fetch_assoc()){
                        $i++;

                        echo"<tr".(($i % 2 == 0) ? " class='row-dark'" : "").">
                                <td class='pos'>".$i."</td>
                                <td class='name-strong'>".$row['clan_name']."</td>
                                <td>".$row['char_name']."</td>
                                <td>".$row['membros']."</td>
                                <td>".$row['ally_name']."</td>
                                <td>".$row['clan_level']."</td>
                                <td>".$row['reputation_score']."</td>
                            </tr>";
                    }
                }
            ?>             
        </tbody>
    </table>
</div>
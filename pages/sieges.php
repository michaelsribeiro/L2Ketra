<?php ?>
<div class="ranking">
    <div class="rank-opt">
        <h1>Castle & Siege</h1>
        <div class="rank-nav">
            <a href="./?pages=toppvp">Top PvP</a>
            <a href="./?pages=toppk" >Top Pk</a>
            <a href="./?pages=topclan">Top Clan</a>
            <a href="./?pages=bosses">Boss Status</a>
            <a href="./?pages=sieges" class="active">Castle & Siege</a>
        </div>
    </div>

    <table cellspacing="0" cellpadding="0" border="0" class="table">
        <thead>
            <tr>
            <th scope="col"></th>
            <th scope="col">CASTLE NAME</th>
            <th scope="col">CLAN OWNER</th>
            <th scope="col">LEADER</th>
            <th scope="col">ALLY</th>
            <th scope="col">NEXT SIEGE</th>
            <th scope="col">ATTACKS</th>
            <th scope="col">DEFENDERS</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i = 0;
                $sql_code = "SELECT 
                            s.id, 
                            s.name,
                            s.siegeDate AS sdate, 
                            c.char_name,
                            d.clan_name,
                            d.ally_name
                        FROM 
                            castle AS s 
                        LEFT JOIN 
                            clan_data AS d ON d.hasCastle = s.id
                        LEFT JOIN 
                            characters AS c ON c.obj_Id = d.leader_id";
                $sql_exec = $mysqli->query($sql_code) or die($mysqli->$error);

                if(mysqli_num_rows($sql_exec) > 0) {
                    while($row = $sql_exec->fetch_assoc()){
                        $i++;
                        
                        $clan_leader = (!empty($row['char_name']) ? $row['char_name'] : 'No Leader');
                        $clan_owner = (!empty($row['clan_name']) ? $row['clan_name'] : 'No Owner');
                        $alliance = (!empty($row['ally_name']) ? $row['ally_name'] : 'No Alliance');
                        $war_day = (strlen($row['sdate']) > 11 ? date('d/m/Y H:i', ($row['sdate']/1000)) : date('d/m/Y H:i', $row['sdate']));
                        $castle_id = $row['id'];
                        $castle = $row['name'];

                        $castle_attacks = 0; $castle_def = 0;

                        $sql_code2 = "SELECT 
                                    s.type, 
                                    d.clan_name
                                FROM 
                                    siege_clans AS s 
                                LEFT JOIN 
                                    clan_data AS d ON d.clan_id = s.clan_id
                                WHERE 
                                    s.castle_id = $castle_id";
                        $sql_exec2 = $mysqli->query($sql_code2) or die($mysqli->$error);

                        if(mysqli_num_rows($sql_exec2) > 0) {
                            while($row = $sql_exec2->fetch_assoc()){
                                $i++;
                                if($row['type'] == 1) {
                                    $castle_attacks++;
                                } else {
                                    $castle_def++;
                                }                            
                            }
                        } else {
                            $castle_attacks = '0'; $castle_def = '0';
                        }
                        
                        echo"<tr".(($i % 2 == 0) ? " class='row-dark'" : "").">
                                <td class='img ".strtolower($castle)."'><span></span></td>
                                <td>".$castle."</td>
                                <td>".$clan_owner."</td>
                                <td>".$clan_leader."</td>
                                <td>".$alliance."</td>
                                <td>".$war_day."</td>
                                <td>".$castle_attacks."</td>
                                <td>".$castle_def."</td>
                            </tr>";
                    }
                }
            ?>             
        </tbody>
    </table>
</div>
<?php include "engine/db_connect.php"; ?>
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
                $sql = "SELECT 
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
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) > 0) {
                    while($fetch = mysqli_fetch_assoc($result)){
                        $i++;
                        
                        $clan_leader = (!empty($fetch['char_name']) ? $fetch['char_name'] : 'No Leader');
                        $clan_owner = (!empty($fetch['clan_name']) ? $fetch['clan_name'] : 'No Owner');
                        $alliance = (!empty($fetch['ally_name']) ? $fetch['ally_name'] : 'No Alliance');
                        $war_day = (strlen($fetch['sdate']) > 11 ? date('d/m/Y H:i', ($fetch['sdate']/1000)) : date('d/m/Y H:i', $fetch['sdate']));
                        $castle_id = $fetch['id'];
                        $castle = $fetch['name'];

                        $castle_attacks = 0; $castle_def = 0; $castle_attacks_name = ''; $castle_def_name = ''; 

                        $sql2 = "SELECT 
                                    s.type, 
                                    d.clan_name
                                FROM 
                                    siege_clans AS s 
                                LEFT JOIN 
                                    clan_data AS d ON d.clan_id = s.clan_id
                                WHERE 
                                    s.castle_id = $castle_id";
                        $result2 = mysqli_query($conn, $sql2);

                        if(mysqli_num_rows($result2) > 0) {
                            while($fetch2 = mysqli_fetch_assoc($result2)){
                                if($fetch2['type'] == 1) {
                                    $castle_attacks++;
                                    $castle_attacks_name .= $fetch2['clan_name'];
                                } else {
                                    $castle_def++;
                                    $castle_def_name .= $fetch2['clan_name'];
                                }                            
                            }
                        } else {
                            $castle_attacks = '0'; $castle_def = '0';
                        }
                        
                         echo 
                         "<tr".(($i % 2 == 0) ? " class='row-dark'" : "").">
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
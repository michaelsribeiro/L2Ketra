<?php

    //$servername = 'localhost';
    //$username = 'root';
    //$password = '';
    //$dbname = 'lineage2db';

    $servername = 'us-cdbr-east-05.cleardb.net';
    $username = 'b2d1def57a4be5';
    $password = '03a148a9';
    $dbname = 'heroku_64fa31b55003450';

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if(!$conn) {
        echo "Conection failed";
    }

?>
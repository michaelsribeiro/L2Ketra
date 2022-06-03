<?php

    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'lineage2db';

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if(!$conn) {
        echo "Conection failed";
    }

?>
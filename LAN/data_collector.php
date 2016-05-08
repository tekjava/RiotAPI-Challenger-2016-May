<?php
/*
|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
|||||                                                                                                         |||||
|||||   THIS FILE GETS THE PLAYERS DATA AUTOMATICLY AND IN THE FUTURE WE'LL CHANGE THE WAY IT COLLECTS DATA   |||||
|||||                                                                                                         |||||
|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
*/
 ?>

<?php

    if(isset($_GET['enable'])) {

        ini_set('max_execution_time', 0);
        header('Content-Type: text/html; charset=utf-8');

        require_once 'connect_db.php';
        include_once 'store_data_riot.php';

        $sql = "SELECT sum_id FROM players_data_LAN";
        $result = $conn->query($sql);

        $entries = array();

        if($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                sleep(2); // Will be changed when production key is available
                $leagueData = json_decode(file_get_contents('https://lan.api.pvp.net/api/lol/lan/v2.5/league/by-summoner/'.$row['sum_id'].'?api_key='.$apiKey));

                if(!isset($leagueData->status)) {
                    foreach ($leagueData->$row['sum_id'][0]->entries as $entry) {
                        array_push($entry->playerOrTeamId);
                    }
                }
            }

            foreach ($entries as $entry) {
                sleep(2); // Will be changed when production key is available
                storeData($conn, $apiKey, $entry, 'players_data_LAN';
            }
        }
        $conn->close;
    } else {
        echo 'Please set $_GET["enable"] to start searching!<br>';
        echo "Example: https://www.site.ff/cron_store_playersData_master_challenger.php?enable=<br>";
    }

 ?>

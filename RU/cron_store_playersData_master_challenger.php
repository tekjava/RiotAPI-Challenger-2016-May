<?php
/*
|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
|||||                                                                                                                               |||||
|||||   THIS FILE GETS THE MASTER AND CHALLENGER PLAYERS DATA AUTOMATICLY AND IN THE FUTURE WE'LL CHANGE THE WAY IT COLLECTS DATA   |||||
|||||                                                                                                                               |||||
|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
*/
 ?>

<?php

    if(isset($_GET['enable'])) {

        ini_set('max_execution_time', 0);
        header('Content-Type: text/html; charset=utf-8');

        require_once 'connect_db.php';
        include_once 'store_data_riot.php';

        // players that are not in master or challenger
        $playersNotDelete = array();
        $playersAvailable = array();
        $playersDelete = array();

        // Get all of the player ids in master league
        $master_elo = file_get_contents("https://ru.api.pvp.net/api/lol/ru/v2.5/league/master?type=RANKED_SOLO_5x5&api_key=".$apiKey);
        $master_elo_players = json_decode($master_elo)->entries;

        // store players in db
        for ($i=0; $i < count($master_elo_players); $i++) {
            array_push($playersNotDelete, $master_elo_players[$i]->playerOrTeamId);
            if(storeData($conn, $apiKey, (int) $master_elo_players[$i]->playerOrTeamId, "challengerandmaster_data_RU")) {
                sleep(10); // Will be changed when production key is available
            }
            echo "<br>";
        }

        // Get all of the player ids in master league
        $challenger_elo = file_get_contents("https://ru.api.pvp.net/api/lol/ru/v2.5/league/challenger?type=RANKED_SOLO_5x5&api_key=".$apiKey);
        $challenger_elo_players = json_decode($challenger_elo)->entries;

        // store players in db
        for ($i=0; $i < count($challenger_elo_players); $i++) {
            array_push($playersNotDelete, $challenger_elo_players[$i]->playerOrTeamId);
            if(storeData($conn, $apiKey, (int) $challenger_elo_players[$i]->playerOrTeamId, "challengerandmaster_data_RU")) {
                sleep(10); // Will be changed when production key is available
            }
            echo "<br>";
        }

        $sql = "SELECT sum_id FROM challengerandmaster_data_RU";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($playersAvailable, $row['sum_id']);
            }
        }

        $playersDelete = array_diff($playersAvailable, $playersNotDelete);

        foreach ($playersDelete as $playerDelete) {
            $sql = "DELETE FROM challengerandmaster_data_RU WHERE sum_id=".$playerDelete;
            if($conn->query($sql)) {
                echo "Deleted: ".$playerDelete;
                echo "<br>";
            } else {
                echo "Couldn't delete: ".$playerDelete;
                echo "<br>";
            }
        }

        $conn->close();
    } else {
        echo 'Please set $_GET["enable"] to start searching!<br>';
        echo "Example: https://www.site.ff/cron_store_playersData_master_challenger.php?enable=<br>";
    }

?>

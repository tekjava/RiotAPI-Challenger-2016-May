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

        // -------------------------------------------------------
        // THIS IS COPIED CODE SINCE WE RAN OUT OF TIME

        // get playerData data as an object
        class PlayerData {

            // important data
            var $apiKey;
            var $summonerNameOrId;
            var $summonerData;

            // construct with api key and summonerName
            function __construct($apiKey, $summonerNameOrId) {
                $this->apiKey = $apiKey;
                $this->summonerNameOrId = $summonerNameOrId;
                $result;
                $resultHeaders;
                $url;

                // get summoner data
                if(gettype($summonerNameOrId) == 'integer') {
                    sleep(0.1); // Prevents from spamming
                    $url = 'https://euw.api.pvp.net/api/lol/euw/v1.4/summoner/' . $summonerNameOrId . '?api_key=' . $apiKey;
                    $resultHeaders = get_headers($url);
                    //echo 'Found int!';
                } else {
                    sleep(0.1); // Prevents from spamming
                	$url = 'https://euw.api.pvp.net/api/lol/euw/v1.4/summoner/by-name/' . $summonerNameOrId . '?api_key=' . $apiKey;
                    $resultHeaders = get_headers($url);
                    // echo 'Found name!';
                }

                if($resultHeaders[0] == "HTTP/1.1 200 OK") {
                    sleep(0.1); // Prevents from spamming
                    //echo 'Found player!';
                    $result = file_get_contents($url);
                    $sumName_f = mb_strtolower(str_replace(' ', '', $summonerNameOrId), 'UTF-8');
                    $this->summonerData = json_decode($result)->$sumName_f;
                    //print_r($this->summonerData);
                } elseif ($resultHeaders[0] == "HTTP/1.1 404 Not Found") {
                    echo "404 Happened for: ".$summonerNameOrId."<br>".$url;
                } else {
                   echo "Error Happened for: ".$summonerNameOrId."<br>".$url;
                }
            }

            // returns masteryInfo
            public function getChampsInfo() {
                sleep(0.1); // Prevents from spamming
                return json_decode(file_get_contents('https://euw.api.pvp.net/championmastery/location/EUW1/player/' . $this->summonerData->id . '/champions?api_key=' . $this->apiKey));
            }

            // returns summonerInfo
            public function getSummonerData() {
                return $this->summonerData;
            }

            public function getSummonerTier() {
                sleep(0.1); // Prevents from spamming
                $sumonerId = $this->summonerData->id;
                $response = json_decode(file_get_contents('https://euw.api.pvp.net/api/lol/euw/v2.5/league/by-summoner/' . $sumonerId . '/entry?api_key=' . $this->apiKey));
                if(isset($response->status) && $response->status->status_code == 404) {
                    return NULL;
                } else {
                    return $response->$sumonerId;
                }
            }

            public function getRankedChampsInfo() {
                sleep(0.1); // Prevents from spamming
                $response = json_decode(file_get_contents('https://euw.api.pvp.net/api/lol/euw/v1.3/stats/by-summoner/' . $this->summonerData->id . '/ranked?season=SEASON2016&api_key=' . $this->apiKey));
                if(isset($response->status) && $response->status->status_code == 404) {
                    return NULL;
                } else {
                    return $response;
                }
            }
        }

        function storeData($conn, $apiKey, $sumNameOrId, $table) {
            // clear any bugged info
            if (gettype($sumNameOrId) == 'integer') {
                $fixquery = "SELECT * FROM ".$table." WHERE sum_id=".$sumNameOrId;
                $resultfix = $conn->query($fixquery);
                if($resultfix->num_rows > 0) {
                    while ($rowfix = $resultfix->fetch_assoc()) {
                        if($rowfix['champs_info'] == 'N;') {
                            $deletequery = "DELETE FROM ".$table." WHERE sum_id=".$sumNameOrId;
                            if($conn->query($deletequery)) {
                                //echo 'reseted';
                            } else {
                                //echo 'didnt reseted';
                            }
                        }
                    }
                }
            } else {
                $fixquery = "SELECT * FROM ".$table." WHERE sum_name='".$sumNameOrId."'";
                $resultfix = $conn->query($fixquery);
                // var_dump($resultfix);
                if($resultfix->num_rows > 0) {
                    while ($rowfix = $resultfix->fetch_assoc()) {
                        if($rowfix['champs_info'] == 'N;') {
                            $deletequery = "DELETE FROM ".$table." WHERE sum_name='".$sumNameOrId."'";
                            if($conn->query($deletequery)) {
                                //echo 'reseted';
                            } else {
                                //echo 'didnt reseted';
                            }
                        }
                    }
                }
            }

            $time_limit = 3600; // 1 week
            $check_time = checkLimitTime($conn, $sumNameOrId, $table);

            if($check_time >= $time_limit || $check_time = NULL) {
                $sumname_f;
                if(gettype($sumNameOrId) == 'integer') {

                    $sumname_f = (int)$sumNameOrId;
                    // echo "<br>int passing <br>";
                } else {

                    $sumname_f = mb_strtolower(str_replace(' ', '', $sumNameOrId), 'UTF-8');
                }
                $playerData = new PlayerData($apiKey, $sumname_f);
                // echo $sumNameOrId;
                // echo mb_detect_encoding($sumNameOrId);
                $formatedName = str_replace(" ", "", $playerData->summonerData->name);
                $formatedName = mb_strtolower($formatedName, 'UTF-8');
                $sql = "INSERT INTO ".$table." (sum_id, sum_name, last_update, tier_info, ranked_champs_info, champs_info, summoner_info)
                    VALUES (
                        ".$playerData->summonerData->id.",
                        '".$formatedName."', NOW(),
                        '".str_replace("'", "\'",serialize($playerData->getSummonerTier()))."',
                        '".serialize($playerData->getRankedChampsInfo())."',
                        '".serialize($playerData->getChampsInfo())."',
                        '".serialize($playerData->getSummonerData())."')
                        ON DUPLICATE KEY UPDATE sum_name=VALUES(sum_name), champs_info=VALUES(champs_info), summoner_info=VALUES(summoner_info), last_update=NOW(), tier_info=VALUES(tier_info), ranked_champs_info=VALUES(ranked_champs_info)";
                if($conn->query($sql) === TRUE) {
                    echo "Data has been stored for: ".$sumNameOrId;
                    echo "<br>";
                } else {

                    echo "Data has been stored for: ". $sumNameOrId;
                    echo "<br>";
                }
                return true;
            } else {
                echo "Request limit reached for: ".$sumNameOrId;
                echo "<br>";
                return false;
            }
        }

        function checkLimitTime($conn, $sumNameOrId, $table) {
            if(gettype($sumNameOrId) === 'integer') {
                $time_query =  "SELECT TIME_TO_SEC(TIMEDIFF(NOW(), last_update)) AS last_update FROM ".$table." WHERE sum_id=" . $sumNameOrId;
            } else {
                $formatedName = str_replace(" ", "", $sumNameOrId);
                $formatedName = mb_strtolower($formatedName, 'UTF-8');
                $time_query =  "SELECT TIME_TO_SEC(TIMEDIFF(NOW(), last_update)) AS last_update FROM ".$table." WHERE sum_name='" .$formatedName. "'";
            }
            $time_query_res = $conn->query($time_query);
            if($time_query_res->num_rows > 0) {
                $last_update =  $time_query_res->fetch_assoc();
                return $last_update['last_update'];
            } else {
                return 3600; // time limit completed need to put something better
            }
        }

        // ----------------------------------------------------------------------------------------------

        $sql = "SELECT sum_id FROM players_data_BR";
        $result = $conn->query($sql);

        $entries = array();

        if($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $leagueData = json_decode(file_get_contents('https://br.api.pvp.net/api/lol/br/v2.5/league/by-summoner/'.$row['sum_id'].'?api_key='.$apiKey));

                if(!isset($leagueData->status)) {
                    foreach ($leagueData->$row['sum_id'][0]->entries as $entry) {
                        array_push($entry->playerOrTeamId);
                    }
                }
            }

            foreach ($entries as $entry) {
                if(storeData($conn, $apiKey, $entry, 'players_data_BR')) {
                    echo "Stored: ". $entry."<br>";
                } else {
                    echo "Couldn't store: ". $entry ."<br>";
                }
            }
        }
        $conn->close;
    } else {
        echo 'Please set $_GET["enable"] to start searching!<br>';
        echo "Example: https://www.site.ff/cron_store_playersData_master_challenger.php?enable=<br>";
    }

 ?>

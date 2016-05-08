<?php

    header('Content-type: text/html; charset=utf-8');

    // masteryinfo class
    include_once "get_playerData_riot.php";
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
                //echo "Data has been stored for: ".$sumNameOrId;
            } else {
                if($playerData->summonerData = NULL) {
                    header("Location: 404.php");
                } else {
                    header("Location: 404.php");
                }
            }
            return true;
        } else {
            // echo "Request limit reached for: ".$sumNameOrId;
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
?>

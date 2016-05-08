<?php
/*
|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
|||||                                                       |||||
|||||   THIS FILE CREATES THE TOP LIST BY CHAMPION POINTS   |||||
|||||                                                       |||||
|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
*/
 ?>

<?php
require_once 'connect_db.php';

ini_set('max_execution_time', 0);

$emptyQuery = "TRUNCATE top_list_OSCA;";
if($conn->query($emptyQuery)) {

    $sql = "SELECT sum_name, summoner_info, tier_info, champs_info FROM players_data_OSCA";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {

    $players = array();
    $champsPoints = array();

        while ($row = $result->fetch_assoc()) {
            $summonerData = unserialize($row['summoner_info']);
            $tierData = unserialize($row['tier_info']);
            if($tierData == NULL || !isset($tierData)) {
                $tierData = new stdClass();
                $tierData->tier = 'UNRANKED';
                $tierEntry = new stdClass();
                $tierEntry->division = '';
            } else {
                $tierData = $tierData[0];
                $tierEntry = $tierData->entries[0];
            }
            $champsData = unserialize($row['champs_info']);

            foreach ($champsData as $champData) {

                if(!isset($champData->highestGrade)) {
                    $highestGrade = '';
                } else {
                    $highestGrade = $champData->highestGrade;
                }

                array_push($players, array(
                    'champId' => $champData->championId,
                    'profileiconid' => $summonerData->profileIconId,
                    'playerName' => $summonerData->name,
                    'tier' => $tierData->tier,
                    'division' => $tierEntry->division,
                    'highestGrade' => $highestGrade,
                    'championPoints' => $champData->championPoints
                ));
                array_push($champsPoints, $champData->championPoints);
            }
        }


        rsort($champsPoints);

        usort($players, function ($a, $b) use ($champsPoints) {
            $pos_a = array_search($a['championPoints'], $champsPoints);
            $pos_b = array_search($b['championPoints'], $champsPoints);
            return $pos_a - $pos_b;
        });

        $championsPoints = array_values(array_unique($champsPoints));
        $playersByCP = array();

        foreach ($championsPoints as $champsPoint) {
            $sameCPs = array();
            foreach ($players as $player) {
                $sameCP = array();
                if($player['championPoints'] == $champsPoint) {

                    switch ($player['tier']) {
                        case 'BRONZE':
                            switch ($player['division']) {
                                case 'I':
                                    $sameCP['tier'] = 'z5';
                                    break;
                                case 'II':
                                    $sameCP['tier'] = 'z4';
                                    break;
                                case 'III':
                                    $sameCP['tier'] = 'z3';
                                    break;
                                case 'IV':
                                    $sameCP['tier'] = 'z2';
                                    break;
                                case 'V':
                                    $sameCP['tier'] = 'z1';
                                    break;
                                default:
                                    $sameCP['tier'] = 'Error Bronze';
                                    break;
                            }
                            break;
                        case 'SILVER':
                            switch ($player['division']) {
                                case 'I':
                                    $sameCP['tier'] = 'y5';
                                    break;
                                case 'II':
                                    $sameCP['tier'] = 'y4';
                                    break;
                                case 'III':
                                    $sameCP['tier'] = 'y3';
                                    break;
                                case 'IV':
                                    $sameCP['tier'] = 'y2';
                                    break;
                                case 'V':
                                    $sameCP['tier'] = 'y1';
                                    break;
                                default:
                                    $sameCP['tier'] = 'Error Silver';
                                    break;
                            }
                            break;
                        case 'GOLD':
                            switch ($player['division']) {
                                case 'I':
                                    $sameCP['tier'] = 'x5';
                                    break;
                                case 'II':
                                    $sameCP['tier'] = 'x4';
                                    break;
                                case 'III':
                                    $sameCP['tier'] = 'x3';
                                    break;
                                case 'IV':
                                    $sameCP['tier'] = 'x2';
                                    break;
                                case 'V':
                                    $sameCP['tier'] = 'x1';
                                    break;
                                default:
                                    $sameCP['tier'] = 'Error Gold';
                                    break;
                            }
                            break;
                        case 'PLATINUM':
                            switch ($player['division']) {
                                case 'I':
                                    $sameCP['tier'] = 'w5';
                                    break;
                                case 'II':
                                    $sameCP['tier'] = 'w4';
                                    break;
                                case 'III':
                                    $sameCP['tier'] = 'w3';
                                    break;
                                case 'IV':
                                    $sameCP['tier'] = 'w2';
                                    break;
                                case 'V':
                                    $sameCP['tier'] = 'w1';
                                    break;
                                default:
                                    $sameCP['tier'] = 'Error Platinum';
                                    break;
                            }
                            break;
                        case 'DIAMOND':
                            switch ($player['division']) {
                                case 'I':
                                    $sameCP['tier'] = 'v5';
                                    break;
                                case 'II':
                                    $sameCP['tier'] = 'v4';
                                    break;
                                case 'III':
                                    $sameCP['tier'] = 'v3';
                                    break;
                                case 'IV':
                                    $sameCP['tier'] = 'v2';
                                    break;
                                case 'V':
                                    $sameCP['tier'] = 'v1';
                                    break;
                                default:
                                    $sameCP['tier'] = 'Error Diamond';
                                    break;
                            }
                            break;
                        case 'MASTER':
                            $sameCP['tier'] = 'u';
                            break;
                        case 'CHALLENGER':
                            $sameCP['tier'] = 'u';
                            break;
                        default:
                            $sameCP['tier'] = 'Error Tier';
                            break;
                    }
                    $sameCP['player'] = $player;
                    array_push($sameCPs, $sameCP);
                }
            }
            sort($sameCPs);
            foreach ($sameCPs as $sameCP) {
                array_push($playersByCP, $sameCP['player']);
            }
        }

        foreach ($playersByCP as $position => $playerByCP) {
                $tableRow = serialize($playerByCP);

                $sql2 = 'INSERT INTO top_list_OSCA (position, table_row, sum_name, champ_id) VALUES ('.$position.',  \''.$tableRow.'\', \''.mb_strtolower(str_replace(' ', '', $playerByCP['playerName']), 'UTF-8').'\', \''.mb_strtolower(str_replace(' ', '', $playerByCP['champId']), 'UTF-8').'\')';

                if($conn->query($sql2)) {
                    echo 'Insert: '.mb_strtolower(str_replace(' ', '', $playerByCP['playerName']), 'UTF-8').'<br>';
                } else {
                    echo 'Failed: '.$conn->error.'<br>';
                }
        }
    }
}
?>

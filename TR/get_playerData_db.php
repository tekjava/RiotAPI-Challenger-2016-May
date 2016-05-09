<?php

    function getChampPoints($conn, $summonerName, $table) {

        $summonerName = mb_strtolower(str_replace(" ", "", $summonerName), 'UTF-8');

        $sql = "SELECT sum_name, champs_info FROM ".$table." WHERE sum_name='".$summonerName."'";
        $data = $conn->query($sql);

        if($data->num_rows > 0) {
            while($row = $data->fetch_assoc()) {
                $champs_data = unserialize($row["champs_info"]);

                $playerTotalCP = 0;

                foreach ($champs_data as $champ_data) {
                    $playerTotalCP += $champ_data->championPoints;
                }
                return $playerTotalCP;
            }
        } else {
            return false;
        }
    }

    function getMasteryPoints($conn, $summonerName, $table) {

        $summonerName = mb_strtolower(str_replace(" ", "", $summonerName), 'UTF-8');

        $sql = "SELECT champs_info FROM ".$table." WHERE sum_name='".$summonerName."'";
        $data = $conn->query($sql);

        if($data->num_rows > 0) {
            while($row = $data->fetch_assoc()) {
                $champs_data = unserialize($row["champs_info"]);

                $playerTotalMS = 0;

                foreach ($champs_data as $champ_data) {
                    $playerTotalMS += $champ_data->championLevel;
                }
                return $playerTotalMS;
            }
        } else {
            return false;
        }
    }

    function getSummonerInfoDB($conn, $summonerName, $table) {
        $summonerName = mb_strtolower(str_replace(" ", "", $summonerName), 'UTF-8');
        $sql = "SELECT sum_name, summoner_info FROM ".$table." WHERE sum_name='".$summonerName."'";
        $data = $conn->query($sql);

        if($data->num_rows > 0) {
            while($row = $data->fetch_assoc()) {
                $summoner_data = unserialize($row["summoner_info"]);
                return $summoner_data;
            }
        } else {
            return false;
        }
    }

    function getChampsInfoDB($conn, $summonerName, $table) {
        $summonerName = mb_strtolower(str_replace(" ", "", $summonerName), 'UTF-8');
        $sql = "SELECT sum_name, champs_info FROM ".$table." WHERE sum_name='".$summonerName."'";
        $data = $conn->query($sql);

        if($data->num_rows > 0) {
            while($row = $data->fetch_assoc()) {
                $champs_data = unserialize($row["champs_info"]);
                return $champs_data;
            }
        } else {
            return false;
        }
    }

    function getRankedChampsInfoDB($conn, $summonerName, $table) {
        $summonerName = mb_strtolower(str_replace(" ", "", $summonerName), 'UTF-8');
        $sql = "SELECT sum_name, ranked_champs_info FROM ".$table." WHERE sum_name='".$summonerName."'";
        $data = $conn->query($sql);

        if($data->num_rows > 0) {
            while($row = $data->fetch_assoc()) {
                $ranked_champs_data = unserialize($row["ranked_champs_info"]);
                return $ranked_champs_data;
            }
        } else {
            return false;
        }
    }

    function getTierInfoDB($conn, $summonerName, $table) {
        $summonerName = mb_strtolower(str_replace(" ", "", $summonerName), 'UTF-8');
        $sql = "SELECT sum_name, tier_info FROM ".$table." WHERE sum_name='".$summonerName."'";
        $data = $conn->query($sql);

        if($data->num_rows > 0) {
            while($row = $data->fetch_assoc()) {
                $tier_data = unserialize($row["tier_info"]);
                return $tier_data;
            }
        } else {
            return false;
        }
    }

 ?>

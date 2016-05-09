
<?php

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
            $url = 'https://br.api.pvp.net/api/lol/br/v1.4/summoner/' . $summonerNameOrId . '?api_key=' . $apiKey;
            $resultHeaders = get_headers($url);
            //echo 'Found int!';
        } else {
            sleep(0.1); // Prevents from spamming
        	$url = 'https://br.api.pvp.net/api/lol/br/v1.4/summoner/by-name/' . $summonerNameOrId . '?api_key=' . $apiKey;
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
            header("Location: 404.php");
        } else {
           header("Location: 404.php");
        }
    }

    // returns masteryInfo
    public function getChampsInfo() {
        sleep(0.1); // Prevents from spamming
        return json_decode(file_get_contents('https://br.api.pvp.net/championmastery/location/BR1/player/' . $this->summonerData->id . '/champions?api_key=' . $this->apiKey));
    }

    // returns summonerInfo
    public function getSummonerData() {
        return $this->summonerData;
    }

    public function getSummonerTier() {
        sleep(0.1); // Prevents from spamming
        $sumonerId = $this->summonerData->id;
        $response = json_decode(file_get_contents('https://br.api.pvp.net/api/lol/br/v2.5/league/by-summoner/' . $sumonerId . '/entry?api_key=' . $this->apiKey));
        if(isset($response->status) && $response->status->status_code == 404) {
            return NULL;
        } else {
            return $response->$sumonerId;
        }
    }

    public function getRankedChampsInfo() {
        sleep(0.1); // Prevents from spamming
        $response = json_decode(file_get_contents('https://br.api.pvp.net/api/lol/br/v1.3/stats/by-summoner/' . $this->summonerData->id . '/ranked?season=SEASON2016&api_key=' . $this->apiKey));
        if(isset($response->status) && $response->status->status_code == 404) {
            return NULL;
        } else {
            return $response;
        }
    }
}

?>

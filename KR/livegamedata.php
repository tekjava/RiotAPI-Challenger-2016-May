<?php
	include_once 'common.php';
	require_once 'connect_db.php';
	include_once 'get_playerData_db.php';
	include_once 'store_data_riot.php';

	ini_set('max_execution_time', 0);

	if(isset($_GET['userName'])) {
	  	$formatedUserName = str_replace(" ", "", $_GET['userName']);
	  	$formatedUserName = mb_strtolower($formatedUserName, 'UTF-8');

		$playersPlaying = array(
			"100" => array(),
			"200" => array()
		);

		$bannedChamps = array(
			"100" => array(),
			"200" => array(),
			"Error" => array()
		);

		$sumData = getSummonerInfoDB($conn, $formatedUserName, 'players_data_KR');

		if($sumData == false) {
			$sumData = json_decode(file_get_contents("https://kr.api.pvp.net/api/lol/kr/v1.4/summoner/by-name/".$formatedUserName."?api_key=".$apiKey))->$formatedUserName;
		}

		$sumiconid = $sumData->profileIconId;
		$sumId = $sumData->id;
		$url = 'https://kr.api.pvp.net/observer-mode/rest/consumer/getSpectatorGameInfo/KR/'.$sumId.'?api_key='.$apiKey;
		$dataHeader = get_headers($url);

		if ($dataHeader[0] == 'HTTP/1.1 200 OK') {
    		$data = json_decode(file_get_contents($url));

			foreach ($data->bannedChampions as $bannedChamp) {
	    		if ($bannedChamp->teamId == 100) {
	    			array_push($bannedChamps["100"], $bannedChamp->championId);
	    		} elseif ($bannedChamp->teamId == 200) {
	    			array_push($bannedChamps["200"], $bannedChamp->championId);
	    		} else {
					array_push($bannedChamps["Error"], $bannedChamp->championId);
				}
	    	}


		    foreach ($data->participants as $participant) {
				// echo $participant->summonerName."<br>";
		    	$name = mb_strtolower(str_replace(' ', '', $participant->summonerName), 'UTF-8');
				//  echo $name;
				$sumInfoDB = getSummonerInfoDB($conn, $name, 'players_data_KR');
			    $champsInfoDB = getChampsInfoDB($conn, $name, 'players_data_KR');
			    $playingChamp = NULL;
			    $rankedInfoDB = getTierInfoDB($conn, $name, 'players_data_KR');
				$rankedChampsInfoDB = getRankedChampsInfoDB($conn, $name, 'players_data_KR');
				//  print_r($champsInfoDB);
				//  echo '<br>';

		    if ($champsInfoDB == false || $champsInfoDB == NULL) {
				sleep(2);
		    	storeData($conn, $apiKey, $name, 'players_data_KR');
		 		sleep(2);
				header("Refresh:0");

			} else {
    			foreach ($champsInfoDB as $champInfoDB) {
    				if($participant->championId == $champInfoDB->championId) {
    					$playingChamp = $champInfoDB;
    				}
    			}

				if($playingChamp == NULL) {
					$playingChamp = json_decode(file_get_contents('https://kr.api.pvp.net/championmastery/location/KR/player/'.$sumId.'/champion/'.$participant->championId.'?api_key='.$apiKey));
					// var_dump($playingChamp);
				}
    		}
			if(!isset($playingChamp->highestGrade)) {
				$playingChamp->highestGrade = '';
			}

			if ($rankedInfoDB == false || $rankedInfoDB == NULL) {
    			$rankedInfoDB = new stdClass();
				$rankedInfoDB->tier = 'UNRANKED';
				$entry = new stdClass();
				$entry->division = '';
			} else {
				// print_r($rankedInfoDB[0]->entries);
				$entry = $rankedInfoDB[0]->entries[0];
			}

	 		$rankedChampInfo = NULL;

	 		if ($rankedChampsInfoDB == false || $rankedChampsInfoDB == NULL) {

				$rankedChampInfo = new stdClass();
		        $rankedChampInfo->totalDeathsPerSession = 0;
		        $rankedChampInfo->totalSessionsPlayed = 1;
		        $rankedChampInfo->totalMinionKills = 0;
		        $rankedChampInfo->totalChampionKills = 0;
		        $rankedChampInfo->totalAssists = 0;
		        $rankedChampInfo->totalSessionsLost = 0;
		        $rankedChampInfo->totalSessionsWon = 0;
		        $rankedChampInfo->totalGoldEarned = 0;

			} else {
				foreach ($rankedChampsInfoDB->champions as $rankedChampInfoDB) {
					if(isset($rankedChampInfoDB->id)) {
						if($rankedChampInfoDB->id == $playingChamp->championId) {
							$rankedChampInfo = $rankedChampInfoDB->stats;
						}
					}
				}
			}

	    	array_push($playersPlaying[$participant->teamId], array(
				"name" => $participant->summonerName,
				"participant" => $participant,
				"sumInfo" => $sumInfoDB,
	    		"champInfo" => $playingChamp,
	    		"rankedInfo" => $rankedInfoDB,
				"entry" => $entry,
				"rankedChampInfo" => $rankedChampInfo
	    	));
	    }


		$mapId = $data->mapId;
		$gameQueueConfigId = $data->gameQueueConfigId;

	} else {
    	header("Location: 404notingame.php");
	}

 } else {
 header("Location: 404notingame.php");
 }


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">

<head> <!-- HEAD OPENS -->
    <title> <?php echo $sumData->name;?> - <?php echo $lang['HOME_HOMEPAGE_TITLE_lIVEGAMES']; ?></title> <!-- Page Title -->
    <meta charset="utf-8">
    <meta name="description" content="Lookup League of Legends summoner mastery data, analyse summoners and strive to become the world's best player with your favourite champions in our ladder">
    <meta name="keywords" content="league of legends,lol,summoner lookup,game lookup,summoner stats,summoner ranking,skill,score,top summoners,champions,summoner stats,champion information,live games,streams, lol masterys, champion mastery">
    <meta name="viewport" content="width=device-width">
    <meta property="og:url" content="profile.php">
    <meta property="og:type" content="website">
    <meta property="og:title" content="League of Legends Game &amp; Summoner Mastery Lookup">
    <meta property="og:locale" content="en_GB">
    <meta property="og:description" content="Lookup your Champion Mastery's and aim to become the best with those champions with our ladder!">
    <meta property="og:site_name" content="Champion Mastery Checker">
    <link rel="shortcut icon" href="Favicon.ico" type="image/x-icon"> <!-- ICON -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans|Oswald">

    <link rel="stylesheet" href="css/basetest.css" media="all"> <!-- Base CSS for the entire site -->
    <link href="css/summoner87f5.css" rel="stylesheet" type="text/css"> <!-- CSS for profile page -->

  <style style="text/css">body{background:#121212;background-image:url(img/background/Background6.jpg);background-size:cover;background-attachment:fixed;background-position:center top;background-repeat:no-repeat;}@media (max-width: 1200px) {body{background-size:initial;}}</style>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
  <script type="text/javascript">
  	$(function() {
  		$("#loading").remove();
  	});
  </script>

</head> <!-- HEAD CLOSES -->

<body> <!-- BODY OPENS -->

	<h1 id="loading"><?php echo $lang['LOADING_LIVEGAME']; ?></h1>

    <div id="dataProvider"></div> <!-- Data Provider -->
    <div id="wrapOuter">

        <!-- Navigation Bar OPENS -->
        <nav>

		    <!-- Language Bar OPEN -->
            <div class="HeaderTools">
		        <dl>
			    <dd class="Region">
			        <a href="#" onclick="showIFrame('#');return false;"><i class='__spSite __spSite-107'></i><?php echo $lang['LANG_TOP']; ?></a>
			    </dd>
			    </dl>
		    </div>
			<!-- Language Bar CLOSE -->

            <!-- Navigation Bar Titles OPEN -->
            <a href="index.php"><?php echo $lang['NAV_HOME']; ?></a>
			<a href="Master&Challenger_ChampionPoints.php"><?php echo $lang['NAV_CHALLENGER_MASTER_LADDER']; ?></a>
			<a href="TopChampionsMasteryLadder.php"><?php echo $lang['NAV_CHAMPION_MASTERY_LADDER']; ?></a>
			<a href="LiveGame.php" style="  display: inline-block;padding: 10px 20px;font-size: 18px;font-weight: normal!important;color: #28b!important;background: #191925;"><?php echo $lang['NAV_INGAME_INFO']; ?></a>
			<!-- Navigation Bar Titles CLOSE -->

			<!-- Social Media OPEN -->
            <!--
			<div class="socialMedia">
                <div class="fb-like" data-href="Facebook link" data-width="150" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
            </div>
			-->
            <!-- Social Media CLOSE -->

        </nav>
        <!-- Navigation Bar CLOSES -->


		<div id="wrapContent" class="clearfix">
        <div class="wrapInner">
        <div class="wrapInnerMain">
        <div class="Contentsz center_divz">

            <div class="Logoz">
				<!-- LOGO Beside Search Bar -->
				<img src="LOLLOGO.png" title="LoLMastery Logo" class="Imagez">
			</div>

			<form class="SearchInputz" action="livegamedata.php">
				<input type="text" name="userName" class="Summonerz" placeholder="<?php echo $lang['SUMMONER_SEARCH_PLACEHOLDER']; ?>">
				<button class="Buttonz" background-image:url(img/search/loop.png);>
				    <img class="__spSitei216" src="img/search/loop.png"/>
				</button>
			</form>

			<!-- Keeps page in place OPEN -->
            <h1></h1>
			<!-- Keeps page in place END -->

        <div class="ContentWrap">
			<div class="Content">
			    <div class="Contentzs">
	                <div class="SummonerLayoutWrap">
					    <div class="SummonerLayout tabWrap">


						<div class="ContentWrap tabItems" id="SummonerLayoutContent">
												    <div class="tabItem Content SummonerLayoutContent summonerLayout-summary" data-tab-spinner-height="800" data-tab-is-loaded-already="true">
														<div class="headline">

                                                            <img src="http://ddragon.leagueoflegends.com/cdn/6.9.1/img/profileicon/<?php print $sumiconid; ?>.png" alt="">

                                                            <div class="box" style="margin-top:40px;">
                                                                <h2 style="position:relative;top:7.5px;"><?php echo $sumData->name;?></h2>
                                                                <?php
echo '<h3 style="position:relative;top:7.5px;">';
if ($gameQueueConfigId == 0)
{
   echo 'Custom ';
}
else if ($gameQueueConfigId == 8)
{
	 echo 'Normal 3v3 ';
}
else if ($gameQueueConfigId == 2)
{
	 echo 'Normal 5v5 Blind Pick ';
}
else if ($gameQueueConfigId == 14)
{
	 echo 'Normal 5v5 Draft Pick ';
}
else if ($gameQueueConfigId == 4)
{
	 echo 'Ranked Solo 5v5 ';
}
else if ($gameQueueConfigId == 6)
{
	 echo 'Ranked Premade 5v5 ';
}
else if ($gameQueueConfigId == 9)
{
	 echo 'Ranked Premade 3v3 ';
}
else if ($gameQueueConfigId == 41)
{
	 echo 'Ranked Team 3v3 ';
}
else if ($gameQueueConfigId == 42)
{
	 echo 'Ranked Team 5v5 ';
}
else if ($gameQueueConfigId == 16)
{
	 echo 'Dominion 5v5 Blind Pick ';
}
else if ($gameQueueConfigId == 17)
{
	 echo 'Dominion 5v5 Draft Pick ';
}
else if ($gameQueueConfigId == 7)
{
	 echo 'Summoners Rift Coop vs AI ';
}
else if ($gameQueueConfigId == 25)
{
	 echo 'Dominion Coop vs AI ';
}
else if ($gameQueueConfigId == 31)
{
	 echo 'Coop vs AI Intro Bot ';
}
else if ($gameQueueConfigId == 32)
{
	 echo 'Coop vs AI Beginner Bot ';
}
else if ($gameQueueConfigId == 33)
{
	 echo 'Coop vs AI Intermediate Bot ';
}
else if ($gameQueueConfigId == 52)
{
	 echo 'Coop vs AI ';
}
else if ($gameQueueConfigId == 61)
{
	 echo 'Team Builder ';
}
else if ($gameQueueConfigId == 65)
{
	 echo 'ARAM ';
}
else if ($gameQueueConfigId == 70)
{
	 echo 'One for All ';
}
else if ($gameQueueConfigId == 72)
{
	 echo 'Showdown 1v1 ';
}
else if ($gameQueueConfigId == 73)
{
	 echo 'Showdown 2v2 ';
}
else if ($gameQueueConfigId == 75)
{
	 echo 'Hexakill ';
}
else if ($gameQueueConfigId == 76)
{
	 echo 'Ultra Rapid Fire ';
}
else if ($gameQueueConfigId == 83)
{
	 echo 'Ultra Rapid Fire vs AI ';
}
else if ($gameQueueConfigId == 91)
{
	 echo 'Doom Bots Rank 1 ';
}
else if ($gameQueueConfigId == 92)
{
	 echo 'Doom Bots Rank 2 ';
}
else if ($gameQueueConfigId == 93)
{
	 echo 'Doom Bots Rank 5 ';
}
else if ($gameQueueConfigId == 96)
{
	 echo 'Ascension ';
}
else if ($gameQueueConfigId == 98)
{
	 echo 'Hexakill ';
}
else if ($gameQueueConfigId == 100)
{
	 echo 'Butchers Bridge ';
}
else if ($gameQueueConfigId == 300)
{
	 echo 'Poro King ';
}
else if ($gameQueueConfigId == 310)
{
	 echo 'Nemesis ';
}
else if ($gameQueueConfigId == 313)
{
	 echo 'Black Market Brawlers ';
}
else if ($gameQueueConfigId == 400)
{
	 echo 'Normal 5v5 Draft Pick ';
}
else if ($gameQueueConfigId == 410)
{
	 echo 'Ranked 5v5 Draft Pick ';
}echo '· ';
if ($mapId == 1)
{
	echo 'Summoner&#39;s Rift';
}
else if ($mapId == 2)
{
	echo 'Summoner&#39;s Rift';
}
else if ($mapId == 3)
{
	echo 'The Proving Grounds';
}
else if ($mapId == 4)
{
	echo 'Twisted Treeline';
}
else if ($mapId == 8)
{
	echo 'The Crystal Scar';
}
else if ($mapId == 10)
{
	echo 'Twisted Treeline';
}
else if ($mapId == 11)
{
	echo 'Summoner&#39;s Rift';
}
else if ($mapId == 12)
{
	echo 'Howling Abyss';
}
else if ($mapId == 14)
{
	echo 'Butcher&#39;s Bridge';
}echo ' · Europe West</h3>';

?>
                                                                <a href="#" style="position:absolute;margin-top:20px;"><button class="Button SemiRound White" id="UpdateButton" title=".$lang['UPDATE_BUTTON_TITLE']." ><?php echo $lang['SPECTATE_LIVEGAME']; ?></button></a>
                                                            </div>
                                                            <div class="rightBox clearfix">
                                                                <div id="aaaLBATF" class="aaaLB">
                                                                </div>
                                                            </div>
                                                        </div>
		                                            <div style="margin-top:-50px;">


														<?php

														foreach ($playersPlaying['100'] as $blueplayer) {
															$sumSpell1Name = json_decode(file_get_contents('https://global.api.pvp.net/api/lol/static-data/kr/v1.2/summoner-spell/'.$blueplayer['participant']->spell1Id.'?api_key='.$apiKey))->key;
															$sumSpell2Name = json_decode(file_get_contents('https://global.api.pvp.net/api/lol/static-data/kr/v1.2/summoner-spell/'.$blueplayer['participant']->spell2Id.'?api_key='.$apiKey))->key;

															$mastery;

															foreach ($blueplayer['participant']->masteries as $masteryKey) {
																switch ($masteryKey->masteryId) {
																	case 6161:
																		$mastery = $masteryKey->masteryId;
																		break;
																	case 6162:
																		$mastery = $masteryKey->masteryId;
																		break;
																	case 6164:
																		$mastery = $masteryKey->masteryId;
																		break;
																	case 6261:
																		$mastery = $masteryKey->masteryId;
																		break;
																	case 6262:
																		$mastery = $masteryKey->masteryId;
																		break;
																	case 6263:
																		$mastery = $masteryKey->masteryId;
																		break;
																	case 6361:
																		$mastery = $masteryKey->masteryId;
																		break;
																	case 6362:
																		$mastery = $masteryKey->masteryId;
																		break;
																	case 6363:
																		$mastery = $masteryKey->masteryId;
																		break;
																	default:
																		$mastery;
																		break;
																}
															}

															$level = $blueplayer['champInfo']->championLevel;
															$champMastery;

															switch ($level) {
																case 1:
																	$champMastery = 'img/loadingscreen/Champ_Mastery_Ab.png';
																	break;
																case 2:
																	$champMastery = 'img/loadingscreen/Champ_Mastery_Bb.png';
																	break;
																case 3:
																	$champMastery = 'img/loadingscreen/Champ_Mastery_Cb.png';
																	break;
																case 4:
																	$champMastery = 'img/loadingscreen/Champ_Mastery_Db.png';
																	break;
																case 5:
																	$champMastery = 'img/loadingscreen/Champ_Mastery_S1b.png';
																	break;
																default:
																	$champMastery = '';
																	break;
															}

															$border = NULL;
															switch ($blueplayer['rankedInfo'][0]->tier) {
																case 'BRONZE':
																	$border = 'bronze';
																	break;
																case 'SILVER':
																	$border = 'silver';
																	break;
																case 'GOLD':
																	$border = 'gold';
																	break;
																case 'PLATINUM':
																	$border = 'platinum';
																	break;
																case 'DIAMOND':
																	$border = 'diamond';
																	break;
																case 'MASTER':
																	$border = 'master';
																	break;
																case 'CHALLENGER':
																	$border = 'challenger';
																	break;
																default:
																	$border = 'blue';
																	break;
															}

															echo '<div class="searchgameladderinline" style="position: relative; width: 200px; height: 270px;">
	                                                                <img width="170px" height="265px" style="position: absolute; margin-left:10px; margin-top:8px; z-index: 1;" src="img/loadingscreen/champs/'.$blueplayer['champInfo']->championId.'.jpg" />
						                                            <img width="37.5px" style="position: absolute;  z-index: 6;top:288px;left:9px;" src="http://ddragon.leagueoflegends.com/cdn/6.9.1/img/profileicon/'.$blueplayer['sumInfo']->profileIconId.'.png" />
						                                            <img width="25px" style="position: absolute;  z-index: 6;top:294.5px;left:71px;" src="http://ddragon.leagueoflegends.com/cdn/6.9.1/img/spell/'.$sumSpell1Name.'.png" />
						                                            <img width="25px" style="position: absolute;  z-index: 6;top:294.5px;left:102px;" src="http://ddragon.leagueoflegends.com/cdn/6.9.1/img/spell/'.$sumSpell2Name.'.png" />
						                                            <img width="28px" style="position: absolute;  z-index: 6;top:293px;left:144px;" src="img/loadingscreen/'.$border.'mastbox.png" />
						                                            <img width="25px" style="position: absolute;  z-index: 6;top:294.5px;left:146.59px;" src="http://ddragon.leagueoflegends.com/cdn/6.9.1/img/mastery/'.$mastery.'.png" />
						                                            <img width="40px" style="position: absolute;  z-index: 6;top:150px;left:140px;" src="img/tiers/'.strtolower($blueplayer['rankedInfo'][0]->tier).'_'.strtolower($blueplayer['entry']->division).'.png" />
						                                            <div style="width:3000px;"></div>
			                                                        <img width="190px" style="position: absolute;  z-index: 3;" src="img/loadingscreen/'.$border.'-loading-screen-border.png" />
				                                                    <div style="position: absolute;  z-index: 4;top:170px;left:12px;">
								                                        <table style=" background:rgba(0,0,0,0.800);height:100px;width:167.5px;">
	                                                                        <tbody>
	                                                                            <tr style="position: relative; left: 10px; z-index: 9;">
	                                                                                <td style="position: relative; left: 10px; z-index: 9;" class="statzlivegame" >'.$lang['WINSLOSS_LIVEGAME'].' :</td>
	                                                                                <td style="position: relative; left: -15px; z-index: 9;" class="statzlivegame"><font color="green">'.$blueplayer['rankedChampInfo']->totalSessionsWon.'</font> - <font color="red">'.$blueplayer['rankedChampInfo']->totalSessionsLost.'</font></td>
	                                                                            </tr>
	                                                                            <tr  style="position: relative; left: 10px; z-index: 9;">
	                                                                                <td style="position: relative; left: 10px; z-index: 9;" class="statzlivegame" >'.$lang['KILLZ_LIVEGAME'].':</td>
	                                                                                <td style="position: relative; left: -15px; z-index: 9;" class="statzlivegame" ><font color="#E6E389">'.number_format($blueplayer['rankedChampInfo']->totalChampionKills/$blueplayer['rankedChampInfo']->totalSessionsPlayed, 0).'</font></td>
	                                                                            </tr>
	                                                                            <tr style="position: relative; left: 10px; z-index: 9;" class="tooltip">
	                                                                                <td style="position: relative; left: 10px; z-index: 9;" class="statzlivegame" >'.$lang['DEATHZ_LIVEGAME'].':</td>
	                                                                                <td style="position: relative; left: -15px; z-index: 9;" class="statzlivegame" ><font color="#E6E389">'.number_format($blueplayer['rankedChampInfo']->totalDeathsPerSession/$blueplayer['rankedChampInfo']->totalSessionsPlayed, 0).'</font></td>
	                                                                            </tr>
	                                                                            <tr style="position: relative; left: 10px; z-index: 9;" class="tooltip">
	                                                                                <td style="position: relative; left: 10px; z-index: 9;" class="statzlivegame" >'.$lang['ASSISTS_LIVEGAME'].':</td>
	                                                                                <td style="position: relative; left: -15px; z-index: 9;" class="statzlivegame" ><font color="#E6E389">'.number_format($blueplayer['rankedChampInfo']->totalAssists/$blueplayer['rankedChampInfo']->totalSessionsPlayed, 0).'</font></td>
	                                                                            </tr>
	                                                                            <tr style="position: relative; left: 10px; z-index: 9;" class="tooltip">
	                                                                                <td style="position: relative; left: 10px; z-index: 9;" class="statzlivegame" >'.$lang['CS_LIVEGAME'].':</td>
	                                                                                <td style="position: relative; left: -15px; z-index: 9;" class="statzlivegame" ><font color="#E6E389">'.number_format($blueplayer['rankedChampInfo']->totalMinionKills/$blueplayer['rankedChampInfo']->totalSessionsPlayed, 0).'</font></td>
	                                                                            </tr>
	                                                                            <tr style="position: relative; left: 10px; z-index: 9;" class="tooltip">
	                                                                                <td style="position: relative; left: 10px; z-index: 9;" class="statzlivegame" >'.$lang['GOLD_LIVEGAME'].':</td>
	                                                                                <td style="position: relative; left: -15px; z-index: 9;" class="statzlivegame" ><font color="#E6E389">'.number_format($blueplayer['rankedChampInfo']->totalGoldEarned/$blueplayer['rankedChampInfo']->totalSessionsPlayed, 0).'</font></td>
	                                                                            </tr>
	                                                                        </tbody>
					                                                    </table>
							                                        </div>
		                                                            <div style="position: absolute;  z-index: 12;top:263.5px;left:15px;width:162px;">
	                                                                    <a href="/profile.php?userName='.$blueplayer['name'].'"><h2 style="font-size:12px; z-index: 12;" align="center" ><font color="white">'.$blueplayer['name'].'</font><h2></a>
	                                                                </div>
							                                        <img width="45px" style="position: absolute;  z-index: 9;top:-18px;left:75px;" src="'.$champMastery.'" />
	                                                                <div style="position: absolute;  z-index: 4;top:10px;left:15px;background:rgba(0,0,0,0.900);height:30px;width:162px;">
	                                                                    <h2  style="font-size:11px;display: inline;" align="center"> &nbsp;&nbsp;&nbsp;'.number_format($blueplayer['champInfo']->championPoints).' CP</h2>
	                                                                    <h2  style="font-size:11px;display: inline; position: relative; left: 60px;" align="center"> '.$blueplayer['champInfo']->highestGrade.'</h2>
							                                        </div>
					                                            </div>';
														}

														 ?>

														</div>
				                                        <br style="line-height:350px;">
                                                        <div class="bans">

															<?php

																foreach ($bannedChamps['100'] as $bannedChamp) {
																	echo '<div  class="banslivegameblue"><img style="position:absolute;" width="32px" src="img/champion/'.$bannedChamp.'.png"/><img style="position:absolute;" src="img/loadingscreen/ban.png"/></div>';

																}

															 ?>

														</div>

									                    <div align="center" style="position: relative;margin-bottom:30px;margin-top:65px;">

											                <h3><font style="font-size:32.5px;"color="#999999">VS</font></h3>

											            </div>


														<div class="bans">

															<?php

																foreach ($bannedChamps['200'] as $bannedChamp) {
																	echo '<div  class="banslivegameblue"><img style="position:absolute;" width="32px" src="img/champion/'.$bannedChamp.'.png"/><img style="position:absolute;" src="img/loadingscreen/ban.png"/></div>';

																}

															 ?>
														</div>
											            <br style="line-height:60px;">
											            <div>

				                                            <?php

															foreach ($playersPlaying['200'] as $redplayer) {
																$sumSpell1Name = json_decode(file_get_contents('https://global.api.pvp.net/api/lol/static-data/kr/v1.2/summoner-spell/'.$blueplayer['participant']->spell1Id.'?api_key='.$apiKey))->key;
																$sumSpell2Name = json_decode(file_get_contents('https://global.api.pvp.net/api/lol/static-data/kr/v1.2/summoner-spell/'.$blueplayer['participant']->spell2Id.'?api_key='.$apiKey))->key;

																$mastery;

																foreach ($redplayer['participant']->masteries as $masteryKey) {
																	switch ($masteryKey->masteryId) {
																		case 6161:
																			$mastery = $masteryKey->masteryId;
																			break;
																		case 6162:
																			$mastery = $masteryKey->masteryId;
																			break;
																		case 6164:
																			$mastery = $masteryKey->masteryId;
																			break;
																		case 6261:
																			$mastery = $masteryKey->masteryId;
																			break;
																		case 6262:
																			$mastery = $masteryKey->masteryId;
																			break;
																		case 6263:
																			$mastery = $masteryKey->masteryId;
																			break;
																		case 6361:
																			$mastery = $masteryKey->masteryId;
																			break;
																		case 6362:
																			$mastery = $masteryKey->masteryId;
																			break;
																		case 6363:
																			$mastery = $masteryKey->masteryId;
																			break;
																		default:
																			$mastery;
																			break;
																	}
																}

																$level = $redplayer['champInfo']->championLevel;
																$champMastery;

																switch ($level) {
																	case 1:
																		$champMastery = 'img/loadingscreen/Champ_Mastery_Ab.png';
																		break;
																	case 2:
																		$champMastery = 'img/loadingscreen/Champ_Mastery_Bb.png';
																		break;
																	case 3:
																		$champMastery = 'img/loadingscreen/Champ_Mastery_Cb.png';
																		break;
																	case 4:
																		$champMastery = 'img/loadingscreen/Champ_Mastery_Db.png';
																		break;
																	case 5:
																		$champMastery = 'img/loadingscreen/Champ_Mastery_S1b.png';
																		break;
																	default:
																		$champMastery = '';
																		break;
																}

																$border = NULL;
																switch ($redplayer['rankedInfo'][0]->tier) {
																	case 'BRONZE':
																		$border = 'bronze';
																		break;
																	case 'SILVER':
																		$border = 'silver';
																		break;
																	case 'GOLD':
																		$border = 'gold';
																		break;
																	case 'PLATINUM':
																		$border = 'platinum';
																		break;
																	case 'DIAMOND':
																		$border = 'diamond';
																		break;
																	case 'MASTER':
																		$border = 'master';
																		break;
																	case 'CHALLENGER':
																		$border = 'challenger';
																		break;
																	default:
																		$border = 'blue';
																		break;
																}

																echo '<div class="searchgameladderinline" style="position: relative; width: 200px; height: 270px;">
		                                                                <img width="170px" height="265px" style="position: absolute; margin-left:10px; margin-top:8px; z-index: 1;" src="img/loadingscreen/champs/'.$redplayer['champInfo']->championId.'.jpg" />
							                                            <img width="37.5px" style="position: absolute;  z-index: 6;top:288px;left:9px;" src="http://ddragon.leagueoflegends.com/cdn/6.9.1/img/profileicon/'.$redplayer['sumInfo']->profileIconId.'.png" />
							                                            <img width="25px" style="position: absolute;  z-index: 6;top:294.5px;left:71px;" src="http://ddragon.leagueoflegends.com/cdn/6.9.1/img/spell/'.$sumSpell1Name.'.png" />
							                                            <img width="25px" style="position: absolute;  z-index: 6;top:294.5px;left:102px;" src="http://ddragon.leagueoflegends.com/cdn/6.9.1/img/spell/'.$sumSpell2Name.'.png" />
							                                            <img width="28px" style="position: absolute;  z-index: 6;top:293px;left:144px;" src="img/loadingscreen/'.$border.'mastbox.png" />
							                                            <img width="25px" style="position: absolute;  z-index: 6;top:294.5px;left:146.59px;" src="http://ddragon.leagueoflegends.com/cdn/6.9.1/img/mastery/'.$mastery.'.png" />
							                                            <img width="40px" style="position: absolute;  z-index: 6;top:150px;left:140px;" src="img/tiers/'.strtolower($redplayer['rankedInfo'][0]->tier).'_'.strtolower($redplayer['entry']->division).'.png"  />
							                                            <div style="width:3000px;"></div>
				                                                        <img width="190px" style="position: absolute;  z-index: 3;" src="img/loadingscreen/'.$border.'-loading-screen-border.png" />
					                                                    <div style="position: absolute;  z-index: 4;top:170px;left:12px;">
									                                        <table style=" background:rgba(0,0,0,0.800);height:100px;width:167.5px;">
		                                                                        <tbody>
		                                                                            <tr style="position: relative; left: 10px; z-index: 9;">
		                                                                                <td style="position: relative; left: 10px; z-index: 9;" class="statzlivegame" >'.$lang['WINSLOSS_LIVEGAME'].' :</td>
		                                                                                <td style="position: relative; left: -15px; z-index: 9;" class="statzlivegame" ><font color="green">'.$redplayer['rankedChampInfo']->totalSessionsWon.'</font> - <font color="red">'.$redplayer['rankedChampInfo']->totalSessionsLost.'</font></td>
		                                                                            </tr>
		                                                                            <tr  style="position: relative; left: 10px; z-index: 9;">
		                                                                                <td style="position: relative; left: 10px; z-index: 9;" class="statzlivegame" >'.$lang['KILLZ_LIVEGAME'].':</td>
		                                                                                <td style="position: relative; left: -15px; z-index: 9;" class="statzlivegame" ><font color="#E6E389">'.number_format($redplayer['rankedChampInfo']->totalChampionKills/$redplayer['rankedChampInfo']->totalSessionsPlayed, 0).'</font></td>
		                                                                            </tr>
		                                                                            <tr style="position: relative; left: 10px; z-index: 9;" class="tooltip">
		                                                                                <td style="position: relative; left: 10px; z-index: 9;" class="statzlivegame" >'.$lang['DEATHZ_LIVEGAME'].':</td>
		                                                                                <td style="position: relative; left: -15px; z-index: 9;" class="statzlivegame" ><font color="#E6E389">'.number_format($redplayer['rankedChampInfo']->totalDeathsPerSession/$redplayer['rankedChampInfo']->totalSessionsPlayed, 0).'</font></td>
		                                                                            </tr>
		                                                                            <tr style="position: relative; left: 10px; z-index: 9;" class="tooltip">
		                                                                                <td style="position: relative; left: 10px; z-index: 9;" class="statzlivegame" >'.$lang['ASSISTS_LIVEGAME'].':</td>
		                                                                                <td style="position: relative; left: -15px; z-index: 9;" class="statzlivegame" ><font color="#E6E389">'.number_format($redplayer['rankedChampInfo']->totalAssists/$redplayer['rankedChampInfo']->totalSessionsPlayed, 0).'</font></td>
		                                                                            </tr>
		                                                                            <tr style="position: relative; left: 10px; z-index: 9;" class="tooltip">
		                                                                                <td style="position: relative; left: 10px; z-index: 9;" class="statzlivegame" >'.$lang['CS_LIVEGAME'].':</td>
		                                                                                <td style="position: relative; left: -15px; z-index: 9;" class="statzlivegame" ><font color="#E6E389">'.number_format($redplayer['rankedChampInfo']->totalMinionKills/$redplayer['rankedChampInfo']->totalSessionsPlayed, 0).'</font></td>
		                                                                            </tr>
		                                                                            <tr style="position: relative; left: 10px; z-index: 9;" class="tooltip">
		                                                                                <td style="position: relative; left: 10px; z-index: 9;" class="statzlivegame" >'.$lang['GOLD_LIVEGAME'].':</td>
		                                                                                <td style="position: relative; left: -15px; z-index: 9;" class="statzlivegame" ><font color="#E6E389">'.number_format($redplayer['rankedChampInfo']->totalGoldEarned/$redplayer['rankedChampInfo']->totalSessionsPlayed, 0).'</font></td>
		                                                                            </tr>
		                                                                        </tbody>
						                                                    </table>
								                                        </div>
			                                                            <div style="position: absolute;  z-index: 12;top:263.5px;left:15px;width:162px;">
		                                                                    <a href="/profile.php?userName='.$redplayer['name'].'"><h2 style="font-size:12px; z-index: 12;" align="center"><font color="white">'.$redplayer['name'].'</font><h2></a>
		                                                                </div>
								                                        <img width="45px" style="position: absolute;  z-index: 9;top:-18px;left:75px;" src="'.$champMastery.'" />
		                                                                <div style="position: absolute;  z-index: 4;top:10px;left:15px;background:rgba(0,0,0,0.900);height:30px;width:162px;">
		                                                                    <h2 title="Champion Points" style="font-size:11px;display: inline;" align="center"> &nbsp;&nbsp;&nbsp;'.number_format($redplayer['champInfo']->championPoints).' CP</h2>
		                                                                    <h2 title="Grade Achieved with this Champion" style="font-size:11px;display: inline; position: relative; left: 60px;" align="center"> '.$redplayer['champInfo']->highestGrade.'</h2>
								                                        </div>
						                                            </div>';
															}

															 ?>
			                                            </div>




			</div></div>



		            </div>
	            </div>
            </div>
        </div>
        </div>
        </div>
        </div>
        </div>
    </div>
</div>
    <!-- FOOTER OPEN -->
    <footer>
        <div class="wrapInner">
            &copy; 2016 LoLMastery.NET &middot;
		    <a href="about.html">About LoLMastery</a>
		    &middot;
		    <a href="contact.html">Contact Us</a>
		    &middot;
		    <a href="legal/privacy.html">Privacy Policy</a>
		    &middot;

            <div class="socialMedia">
                <a href="#"><img src="img/social/twitter.png" alt="Twitter"></a>
                <a href="#"><img src="img/social/facebook.png" alt="Facebook"></a>
            </div>
        </div>
    </footer>
	<!-- FOOTER CLOSE -->



    <script language="JavaScript">
        function showIFrame(url)
        {
            var container = document.getElementById('containerss');
            var iframebox = document.getElementById('iframebox');
            iframebox.src=url;
            container.style.display = 'block';
        }

        function closeIFrame(url)
        {
            var container = document.getElementById('containerss');
            var iframebox = document.getElementById('iframebox');
            document.getElementById("containerss").style.display = "none";
        }
    </script>

    <!-- SERVER AND LANGUAGE BAR OPEN -->
    <div id="containerss" style="display:none;">
        <div id="demo" class="DimmedBlock ">
            <div class="CenterTableWrapper" style="width: 100%; height: 100%;">
                <table width="100%" height="100%" style="">
                    <tbody class="eztiadiv">
                        <tr>
                            <td>
                                <div class="DimmedBlockInner">
                                    <div onclick="closeIFrame('#');return false;" class="Close"></div>
                                        <div class="Modal RegionTool">
	                                        <p class="Title"><?php echo $lang['REGION_TITLE']; ?> &amp; <?php echo $lang['LANGUAGE_SETTINGS_TITLE']; ?></p>

	                                            <div class="Content">
		                                            <div class="Section Region">
			                                            <h2><?php echo $lang['REGION_TITLE']; ?></h2>
														<!-- REGION TABLE OPENS -->
                                                            <table class="Table">

				                                                <tbody class="Body">

				                                                    <tr class="Row">
																	<!-- KOREA OPENS -->
                                                                        <td class="Cell active">
							                                                <a href="../changeserver.php?serverchange=KR" class="Link">
								                                                <div class="Icon">
									                                                <i class="__spSite __spSite-109"></i>
								                                                </div>
								                                                <div class="Value">Korea</div>


							                                                </a>
						                                                </td>
																	<!-- KOREA CLOSES -->

																	<!-- NA OPENS -->
																		<td class="Cell ">
							                                                <a href="../changeserver.php?serverchange=NA" class="Link">
								                                                <div class="Icon">
									                                                <i class="__spSite __spSite-112"></i>
								                                                </div>
								                                                <div class="Value">North America</div>


							                                                </a>
						                                                </td>
																	<!-- NA CLOSES -->
					                                                </tr>

					                                                <tr class="Row">
																	<!-- EUW OPENS -->
                                                                        <td class="Cell ">
							                                                <a href="../changeserver.php?serverchange=EUW" class="Link">
								                                                <div class="Icon">
									                                                <i class="__spSite __spSite-107"></i>
								                                                </div>
								                                                <div class="Value">Europe West</div>


							                                                </a>
						                                                </td>
																	<!-- EUW CLOSES -->

																	<!-- EUNE OPENS -->
																		<td class="Cell ">
							                                                <a href="../changeserver.php?serverchange=EUNE" class="Link">
								                                                <div class="Icon">
									                                                <i class="__spSite __spSite-106"></i>
								                                                </div>
								                                                <div class="Value">Europe Nordic &amp; East</div>


							                                                </a>
						                                                </td>
																	<!-- EUNE CLOSES -->
					                                                </tr>

					                                                <tr class="Row">
																<!-- OCE OPENS -->
                                                                        <td class="Cell ">
							                                                <a href="../changeserver.php?serverchange=OCE" class="Link">
								                                                <div class="Icon">
									                                                <i class="__spSite __spSite-113"></i>
								                                                </div>
								                                                <div class="Value">Oceania</div>


							                                                </a>
						                                                </td>
																	<!-- OCE CLOSES -->

																	<!-- BR OPENS -->
																	    <td class="Cell ">
							                                                <a href="../changeserver.php?serverchange=BR" class="Link">
								                                                <div class="Icon">
									                                                <i class="__spSite __spSite-105"></i>
								                                                </div>
								                                                <div class="Value">Brazil</div>


							                                                </a>
						                                                </td>
																	<!-- BR CLOSES -->
					                                                </tr>

					                                                <tr class="Row">
																	<!-- LAS OPENS -->
                                                                        <td class="Cell ">
							                                                <a href="../changeserver.php?serverchange=LAS" class="Link">
								                                                <div class="Icon">
									                                                <i class="__spSite __spSite-111"></i>
								                                                </div>
								                                                <div class="Value">LAS</div>


							                                                </a>
						                                                </td>
																	<!-- LAS CLOSES -->

																	<!-- LAN OPENS -->
																		<td class="Cell ">
							                                                <a href="../changeserver.php?serverchange=LAN" class="Link">
								                                                <div class="Icon">
									                                                <i class="__spSite __spSite-110"></i>
								                                                </div>
								                                                <div class="Value">LAN</div>


							                                                </a>
						                                                </td>
																	<!-- LAN CLOSES -->
					                                                </tr>

					                                                <tr class="Row">
																	<!-- RUSSIA OPENS -->
                                                                        <td class="Cell ">
							                                                <a href="../changeserver.php?serverchange=RU" class="Link">
								                                                <div class="Icon">
									                                                <i class="__spSite __spSite-114"></i>
								                                                </div>
								                                                <div class="Value">Russia</div>


							                                                </a>
						                                                </td>
																	<!-- RUSSIA CLOSES -->

																	<!-- TURKEY OPENS -->
																		<td class="Cell ">
							                                                <a href="../changeserver.php?serverchange=TR" class="Link">
								                                                <div class="Icon">
								                                                    <i class="__spSite __spSite-115"></i>
								                                                </div>
								                                                <div class="Value">Turkey</div>


							                                                </a>
						                                                </td>
																	<!-- TURKEY CLOSES -->
					                                                </tr>

															    </tbody>
			                                                </table>
															<!-- REGION TABLE CLOSES -->
		                                            </div>

		                                            <div class="Section Language">
			                                            <h2><?php echo $lang['LANGUAGE_TITLE']; ?></h2>
                                                            <div class="Extra">
		                                                        <a href="/translate/" class="Link"><?php echo $lang['BETTER_TRANSLATION']; ?></a>
			                                                </div>
															<!-- LANGUAGE TABLE OPENS -->
                                                            <table class="Table">
			                                                    <tbody class="Body">

					                                                <tr class="Row">
						                                            <!-- ENGLISH LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="LiveGame.php?lang=en" class="Link">
							                                                    <div class="Value">English</div>
							                                                </a>
						                                                </td>
																	<!-- ENGLISH LANGUAGE CLOSES -->

																	<!-- FRENCH LANGUAGE OPENS -->
						                                                <td class="Cell ">
							                                                <a href="LiveGame.php?lang=fr" class="Link">
							                                                    <div class="Value">Français</div>
							                                                </a>
						                                                </td>
																	<!-- FRENCH LANGUAGE CLOSES -->

																	<!-- GERMAN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="LiveGame.php?lang=de" class="Link">
							                                                    <div class="Value">Deutsche</div>
							                                                </a>
						                                                </td>
																	<!-- GERMAN LANGUAGE CLOSES -->

						                                            <!-- POLAND LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="LiveGame.php?lang=pl" class="Link">
							                                                    <div class="Value">Polskie</div>
							                                                </a>
						                                                </td>
																	<!-- POLAND LANGUAGE CLOSES -->
					                                                </tr>

					                                                <tr class="Row">
																	<!-- KOREAN LANGUAGE OPENS -->
						                                                <td class="Cell ">
							                                                <a href="LiveGame.php?lang=kr" class="Link">
							                                                    <div class="Value">한국어</div>
							                                                </a>
						                                                </td>
																	<!-- KOREAN LANGUAGE CLOSES -->

																	<!-- SWEDISH LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="LiveGame.php?lang=se" class="Link">
							                                                    <div class="Value">Svensk</div>
							                                                </a>
						                                                </td>
                                                                    <!-- SWEDISH LANGUAGE CLOSES -->

						                                            <!-- JAPAN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="LiveGame.php?lang=ja" class="Link">
							                                                    <div class="Value">日本語</div>
							                                                </a>
						                                                </td>
																	<!-- JAPAN LANGUAGE CLOSES -->

						                                            <!-- SPAIN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="LiveGame.php?lang=es" class="Link">
							                                                    <div class="Value">Español</div>
							                                                </a>
						                                                </td>
																	<!-- SPAIN LANGUAGE CLOSES -->
					                                                </tr>

					                                                <tr class="Row">
																	<!-- DANISH LANGUAGE OPENS -->
						                                                <td class="Cell ">
							                                                <a href="LiveGame.php?lang=da" class="Link">
							                                                    <div class="Value">Dansk</div>
							                                                </a>
						                                                </td>
																	<!-- DANISH LANGUAGE CLOSES -->

						                                            <!-- ROMANIAN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="LiveGame.php?lang=rom" class="Link">
							                                                    <div class="Value">Română</div>
							                                                </a>
						                                                </td>
																	<!-- ROMANIAN LANGUAGE CLOSES -->

						                                            <!-- NORWEGIAN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="LiveGame.php?lang=no" class="Link">
							                                                    <div class="Value">Norsk</div>
							                                                </a>
						                                                </td>
																	<!-- NORWEGIAN LANGUAGE CLOSES -->

						                                            <!-- RUSSIAN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="LiveGame.php?lang=ru" class="Link">
							                                                    <div class="Value">Pусский</div>
							                                                </a>
						                                                </td>
																	<!-- RUSSIAN LANGUAGE CLOSES -->
					                                                </tr>

                                                                    <tr class="Row">
																	<!-- HUNGARIAN LANGUAGE OPENS -->
						                                                <td class="Cell ">
							                                                <a href="LiveGame.php?lang=hu" class="Link">
							                                                    <div class="Value">Magyar</div>
							                                                </a>
						                                                </td>
																	<!-- HUNGARIAN LANGUAGE CLOSES -->

						                                            <!-- FINNISH LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="LiveGame.php?lang=fi" class="Link">
							                                                    <div class="Value">Suomalainen</div>
							                                                </a>
						                                                </td>
																	<!-- FINNISH LANGUAGE CLOSES -->

						                                            <!-- TURKISH LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="LiveGame.php?lang=tr" class="Link">
							                                                    <div class="Value">Türk</div>
							                                                </a>
						                                                </td>
																	<!-- TURKISH LANGUAGE CLOSES -->

						                                            <!-- SLOVENIAN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="LiveGame.php?lang=sl" class="Link">
							                                                    <div class="Value">Slovenski</div>
							                                                </a>
						                                                </td>
																	<!-- SLOVENIAN LANGUAGE CLOSES -->
					                                                </tr>

					                                                <tr class="Row">
																	<!-- PORTUGESE LANGUAGE OPENS -->
						                                                <td class="Cell ">
							                                                <a href="LiveGame.php?lang=pt" class="Link">
							                                                    <div class="Value">Português</div>
							                                                </a>
						                                                </td>
																	<!-- PORTUGESE LANGUAGE CLOSES -->

						                                            <!-- CHINESE LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="LiveGame.php?lang=zh" class="Link">
							                                                    <div class="Value">中文</div>
							                                                </a>
						                                                </td>
																	<!-- CHINESE LANGUAGE CLOSES -->

						                                            <!-- SERBIAN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="LiveGame.php?lang=sr" class="Link">
							                                                    <div class="Value">Српски</div>
							                                                </a>
						                                                </td>
																	<!-- SERBIAN LANGUAGE CLOSES -->

						                                            <!-- ITALIAN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="LiveGame.php?lang=it" class="Link">
							                                                    <div class="Value">Italiano</div>
							                                                </a>
						                                                </td>
																	<!-- ITALIAN LANGUAGE CLOSES -->
					                                                </tr>
				                                                </tbody>
			                                                </table>
															<!-- LANGUAGE TABLE CLOSES -->
		                                            </div>
	                                            </div>
                                        </div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
		    </div>
	    </div>
        <iframe src="" name="iframe" id="iframebox" style="display:none;"/>
    </div>
<!-- SERVER AND LANGUAGE BAR CLOSE -->

</body>

</html>

<?php
	include_once 'common.php';
	include_once 'get_playerData_db.php';
	require_once 'connect_db.php';
	include_once 'store_data_riot.php';

	$summonerData;
	$tierInfo;
	$ranked_champs_info;
	$champs_info;

	if(isset($_GET['userName'])) {
		$formatedUserName = str_replace(" ", "", $_GET['userName']);
		$formatedUserName = mb_strtolower($formatedUserName, 'UTF-8');
		$sql = 'SELECT * FROM players_data WHERE sum_name = "' . $formatedUserName.'"';
		$result = $conn->query($sql);
		//echo $formatedUserName;

		if($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$GLOBALS['summonerData'] = unserialize($row['summoner_info']);
				$GLOBALS['tierInfo'] = unserialize($row['tier_info'])[0];
				$GLOBALS['ranked_champs_info'] = unserialize($row['ranked_champs_info']);
				$GLOBALS['champs_info'] = unserialize($row['champs_info']);
			}
		} else {
			storeData($conn, $apiKey, $_GET['userName'], 'players_data');
			header("Refresh:0");
		}
	} else {
		header("Location: /");
	}

	// summoner info
	$summonerId = $summonerData->id;
	$sumiconid = $summonerData->profileIconId;
	$summonerLevel = $summonerData->summonerLevel;
	$summonerName = $summonerData->name;

	$summonerrevisionDate = $summonerData->revisionDate;
    $summonerrevisionDate = substr($summonerrevisionDate, 0, -3);
    $summonerrevisionDatedt = new DateTime("@$summonerrevisionDate"); // convert UNIX timestamp to PHP DateTime

	$maxCPChamp = $champs_info[0]->championId;

	if($tierInfo != NULL) {
		// tier info
		$tier = $tierInfo->tier;
		$entry = $tierInfo->entries[0];
		$Div = $entry->division;
		$LP = $entry->leaguePoints;
		$leagueName = $tierInfo->name;
		$WinsRankedSoloSide = $entry->wins;
		$LossesRankedSoloSide = $entry->losses;
		$Percentwinrate = 100 / ($WinsRankedSoloSide + $LossesRankedSoloSide) * $WinsRankedSoloSide;
	}

	$masteryScore = 0;
	for($i = 0; $i < count($champs_info); $i++) {
		$masteryScore = $masteryScore + $champs_info[$i]->championLevel;
	}

	$championScore = 0;
	for($i = 0; $i < count($champs_info); $i++) {
		$championScore = $championScore + $champs_info[$i]->championPoints;
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">

<head> <!-- HEAD OPENS -->
    <title> <?php print $summonerName; ?> - <?php echo $lang['HOMEPAGE_TITLE']; ?></title> <!-- Page Title -->
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

</head> <!-- HEAD CLOSES -->

<body> <!-- BODY OPENS -->

    <div id="dataProvider" data-current-realm="EUW" data-current-name="<?php print $summonerName; ?>"></div> <!-- Data Provider -->
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
			<a href="LiveGame.php"><?php echo $lang['NAV_INGAME_INFO']; ?></a>
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

			<form class="SearchInputz" action="profile.php">
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
				            <div class="Header">
				                <div class="Face">
								    <div class="ProfileIcon">
									<!-- Rank Border Around Summoner Icon OPEN -->
									    <div class="borderImage" style="background-image: url(
										<?php
										    if ('BRONZE'==$tier) {
	                                            echo 'img/borders/bronze.png';
                                            }
                                            elseif ('SILVER'==$tier) {
	                                            echo 'img/borders/silver.png';
                                            }
                                            elseif ('GOLD'==$tier) {
	                                            echo 'img/borders/gold.png';
                                            }
                                            elseif ('PLATINUM'==$tier) {
	                                            echo 'img/borders/platinum.png';
                                            }
                                            elseif ('DIAMOND'==$tier) {
                                                echo 'img/borders/diamond.png';
                                            }
                                            elseif ('MASTER'==$tier) {
                                                echo 'img/borders/master.png';
                                            }
                                            elseif ('CHALLENGER'==$tier) {
                                                echo 'img/borders/challenger.png';
                                            }
                                            else {}
                                            ?>);">
										</div>
										<!-- Rank Border Around Summoner Icon END -->

                                        <!-- Summoner Icon OPEN -->
									    <img src="http://ddragon.leagueoflegends.com/cdn/6.9.1/img/profileicon/<?php print $sumiconid; ?>.png" class="ProfileImage">
										<!-- Summoner Icon CLOSE-->

										<!-- Summoner Level OPEN -->
									    <span class="Level tip" title="<?php echo $lang['SUMMONER_LEVEL_TITLE']; ?>"><?php print $summonerLevel; ?></span>
										<!-- Summoner Level CLOSE -->
								    </div>
								</div>

								<div class="Profile">
								    <div class="Information">
									    <!-- Summoner Name OPEN -->
									    <span class="Name"><?php print $summonerName; ?></span>
										<!-- Summoner Name CLOSE -->
										<div class="Rank">
									        <div class="LadderRank">
											    <!-- Summoner Level OPEN -->
												<p class="levelcss1"><?php echo $lang['SUMMONER_LEVEL_PAGE']; ?>:&nbsp </p>
												<p class="levelcss"> <?php print $summonerLevel; ?></p>
												<!-- Summoner Name CLOSE -->
												&nbsp&nbsp
												<!-- Summoner Server OPEN -->
												<p class="levelcss1"><?php echo $lang['SUMMONER_SERVER_PAGE']; ?>:&nbsp </p>
												<p class="levelcss">EUW</p>
												<!-- Summoner Server CLOSE -->
		                                        <br>
												<!-- Summoner Last Time Played OPEN -->
												<p class="levelcss1"><?php echo $lang['LAST_GAME_PLAYED']; ?>:&nbsp </p>
												<p class="levelcss"><?php echo $summonerrevisionDatedt->format('d-m-y H:i:s');?></p>
												<!-- Summoner Last Time Played CLOSE -->
												<br>
												<br>
												<?php
                                                    if (isset($_GET['userName'])) {
                                                        if(isset($_GET['update'])) {
                                                                storeData($conn, $apiKey, $_GET['userName'], 'players_data');
                                                        }
                                                        if(checkLimitTime($conn, $_GET['userName'], 'players_data') < 3600) {
                                                            echo '<button class="Button SemiRound UPDATED" id="UpdateButton" title="'.$lang['UPDATED_BUTTON_TITLE'].'" disabled>'.$lang['UPDATED_BUTTON'].'</button>';
                                                        }
														else {
                                                            echo '<a href="profile.php?userName='.$_GET['userName'].'&update="><button class="Button SemiRound White" id="UpdateButton" title="'.$lang['UPDATE_BUTTON_TITLE'].'" >'.$lang['UPDATE_BUTTON'].'</button></a>';
                                                        }
                                                    }
                                                ?>
										    </div>
									    </div>
									</div>
							    </div>
							</div>
					<br>
					        <div id="ExtraView"></div>
					            <div class="ContentWrap tabItems" id="SummonerLayoutContent">
								    <div class="tabItem Content SummonerLayoutContent summonerLayout-summary" data-tab-spinner-height="800" data-tab-is-loaded-already="true">
                                        <div class="SideContent">
										    <div class="TierBox Box">
											    <div class="SummonerRatingMedium tip" title="<?php echo $lang['RANKED_TITLE']; ?>">
												    <!-- DIVISON IMG OPENS -->
												    <div class="Medal">
													    <img src=
														<?php
                                                            if(isset($tier)) {if ('BRONZE'==$tier) {
	                                                            if ('I'==$Div) {
                                                                    echo '"img/tiers/bronze_i.png"';
                                                                }
	                                                            if ('II'==$Div) {
                                                                    echo 'img/tiers/bronze_ii.png';
                                                                }
	                                                            if ('III'==$Div) {
                                                                    echo 'img/tiers/bronze_iii.png';
                                                                }
	                                                            if ('IV'==$Div) {
                                                                    echo 'img/tiers/bronze_iv.png';
                                                                }
	                                                            if ('V'==$Div) {
                                                                    echo 'img/tiers/bronze_v.png';
                                                                }
                                                            }
                                                            elseif ('SILVER'==$tier) {
	                                                            if ('I'==$Div) {
                                                                    echo 'img/tiers/silver_i.png';
                                                                }
	                                                            if ('II'==$Div) {
                                                                    echo 'img/tiers/silver_ii.png';
                                                                }
	                                                            if ('III'==$Div) {
                                                                    echo 'img/tiers/silver_iii.png';
                                                                }
	                                                            if ('IV'==$Div) {
                                                                    echo 'img/tiers/silver_iv.png';
                                                                }
	                                                            if ('V'==$Div) {
                                                                    echo 'img/tiers/silver_v.png';
                                                                }
                                                            }
                                                            elseif ('GOLD'==$tier) {
	                                                            if ('I'==$Div) {
                                                                    echo 'img/tiers/gold_i.png';
                                                                }
	                                                            if ('II'==$Div) {
                                                                    echo 'img/tiers/gold_ii.png';
                                                                }
	                                                            if ('III'==$Div) {
                                                                    echo 'img/tiers/gold_iii.png';
                                                                }
	                                                            if ('IV'==$Div) {
                                                                    echo 'img/tiers/gold_iv.png';
                                                                }
	                                                            if ('V'==$Div) {
                                                                    echo 'img/tiers/gold_v.png';
                                                                }
                                                            }
                                                            elseif ('PLATINUM'==$tier) {
	                                                            if ('I'==$Div) {
                                                                    echo 'img/tiers/platinum_i.png';
                                                                }
	                                                            if ('II'==$Div) {
                                                                    echo 'img/tiers/platinum_ii.png';
                                                                }
	                                                            if ('III'==$Div) {
                                                                    echo 'img/tiers/platinum_iii.png';
                                                                }
	                                                            if ('IV'==$Div) {
                                                                    echo 'img/tiers/platinum_iv.png';
                                                                }
	                                                            if ('V'==$Div) {
                                                                    echo 'img/tiers/platinum_v.png';
                                                                }
                                                            }
                                                            elseif ('DIAMOND'==$tier) {
	                                                            if ('I'==$Div) {
                                                                    echo 'img/tiers/diamond_i.png';
                                                                }
	                                                            if ('II'==$Div) {
                                                                    echo 'img/tiers/diamond_ii.png';
                                                                }
	                                                            if ('III'==$Div) {
                                                                    echo 'img/tiers/diamond_iii.png';
                                                                }
	                                                            if ('IV'==$Div) {
                                                                    echo 'img/tiers/diamond_iv.png';
                                                                }
	                                                            if ('V'==$Div) {
                                                                    echo 'img/tiers/diamond_v.png';
                                                                }
                                                            }
                                                            elseif ('MASTER'==$tier) {
	                                                            if ('I'==$Div) {
                                                                    echo 'img/tiers/master.png';
                                                                }
                                                            }
                                                            elseif ('CHALLENGER'==$tier) {
	                                                            if ('I'==$Div) {
                                                                    echo 'img/tiers/challenger.png';
                                                                }
                                                            }
                                                            else {
                                                                echo 'img/tiers/unranked.png';
                                                            }
														} else {
                                                                echo '"img/tiers/unranked.png"';
														}
                                                        ?> class="Image">
													</div>
													<!-- DIVISON IMG CLOSES -->

				                                    <div class="TierRankInfo">

													    <!-- TIER IMG OPENS -->
													    <div class="TierRank">
														    <span class="tierRank">
															    <?php
                                                                    if (isset($tier)) {
																		if ('BRONZE'==$tier) {
	                                                                        echo 'Bronze';
	                                                                    }
	                                                                    elseif ('SILVER'==$tier) {
	                                                                        echo 'Silver';
	                                                                    }
	                                                                    elseif ('GOLD'==$tier) {
	                                                                        echo 'Gold';
	                                                                    }
	                                                                    elseif ('PLATINUM'==$tier) {
	                                                                        echo 'Platinum';
	                                                                    }
	                                                                    elseif ('DIAMOND'==$tier) {
	                                                                        echo 'Diamond';
	                                                                    }
	                                                                    elseif ('MASTER'==$tier) {
	                                                                        echo 'Master';
	                                                                    }
	                                                                    elseif ('CHALLENGER'==$tier) {
	                                                                        echo 'Challenger';
	                                                                    }
																		else {
																		    echo 'Unranked';
																		}
                                                                    } else {
																		echo 'Unranked';
																	}
																?>
																<?php
																    if(isset($Div)) {
																		print $Div;
																	}
																?>
															</span>
														</div>
														<!-- TIER IMG CLOSES -->

													    <div class="TierInfo">

														    <!-- LP OPENS -->
														    <span class="LeaguePoints">
															    <?php
															        if(isset($LP)) {
																		print $LP;
																	} else {
																		print '0';
																	}
																?> <?php echo $lang['LP_PAGE_BODY']; ?>
															</span> /
															<!-- LP CLOSES -->

															<span class="WinLose">

															    <!-- WINS RANKED SOLO QUEUE OPENS -->
															    <span class="wins">
																    <font color="#04B404">
																	    <?php
																		    if (isset($WinsRankedSoloSide)) {
																		    	print $WinsRankedSoloSide;
																		    }else {
																				print '0';
																			}
																		?>
																	</font> <?php echo $lang['RAKED_BOX_WIN_W']; ?>
																</span>
																<!-- WINS RANKED SOLO QUEUE CLOSES -->

																<!-- LOSSES RANKED SOLO QUEUE OPENS -->
															    <span class="losses"> -
																    <font color="red">
																        <?php
																		    if (isset($LossesRankedSoloSide)) {
																		    	print $LossesRankedSoloSide;
																		    } else {
																				print '0';
																			}
																		?>
																	</font> <?php echo $lang['RAKED_BOX_LOSS_L']; ?>
																</span>
																<!-- LOSSES RANKED SOLO QUEUE CLOSES -->

															    <br>

																<!-- WIN RATIO RANKED SOLO QUEUE OPENS -->
																<span class="winratio"><?php echo $lang['RAKED_BOX_WIN_RATIO']; ?>
																    <?php
                                                                        if (isset($Percentwinrate)) {
																			if ($Percentwinrate <= 49.9) {
	                                                                            echo '<font color="red">'.number_format((float)$Percentwinrate, 1, '.', '').'%</font>';
		                                                                    }
	                                                                        elseif ($Percentwinrate <= 59.9) {
		                                                                        echo '<font color="#F7FE2E">'.number_format((float)$Percentwinrate, 1, '.', '').'%</font>';
		                                                                    }
	                                                                        elseif ($Percentwinrate <= 69.9) {
		                                                                        echo '<font color="#58ACFA">'.number_format((float)$Percentwinrate, 1, '.', '').'%</font>';
		                                                                    }
	                                                                        elseif ($Percentwinrate >69.9) {
		                                                                        echo '<font color="#04B404">'.number_format((float)$Percentwinrate, 1, '.', '').'%</font>';
	                                                                        }
                                                                        }
                                                                    ?>
																</span>
																<!-- WIN RATIO RANKED SOLO QUEUE CLOSES -->

															</span>

														</div>

														<!-- LEAGUE NAME RANKED SOLO QUEUE OPENS -->
                                                        <div class="LeagueName">
                                                            <?php
															    if(isset($leagueName)) {
																	print $leagueName;
																} else {
																	print 'Not ranked';
																}
															?>
                                                        </div>
														<!-- LEAGUE NAME RANKED SOLO QUEUE CLOSES -->

                                                    </div>
												</div>
											</div>
								        </div>

								        <div class="RealContent">
                                            <div class="GameListContainer">
						                        <div class="Content">
												    <div class="Box">
													    <div class="GameAverageStats">
														    <div class="Summary">
															    <div class="WinRatioTitle">
                                                                    <?php echo $lang['BOX_MASTERY_SCORE']; ?>
																	    <font color="#437FC2">
																		    &nbsp;
																			<!-- Mastery Total Score OPENS -->
																			<?php
	                                                                            echo $masteryScore;
                                                                            ?>
																			<!-- Mastery Total Score Closes -->
																		</font>
																    &nbsp; | &nbsp; <?php echo $lang['BOX_TOTAL_MASTERY_CP']; ?>
																		<font color="#437FC2">
																		    &nbsp;
																			<!-- Champion Total Score OPENS -->
																		    <?php
	                                                                            echo number_format($championScore , 0, '.', ',');
                                                                            ?>
																			<!-- Champion Total Score CLOSES -->
																			CP
																		</font>
																		<br>
																		<br>
																		<h4><?php echo $lang['GAMES_PLAYED_WITH_CHAMPRANKONLADDER']; ?> <font style="color:rgb(59, 126, 194);">
																		<?php
																			$getRank = "SELECT position FROM top_list WHERE sum_name='".mb_strtolower(str_replace(' ', '', $summonerName), 'UTF-8')."' AND champ_id=".$maxCPChamp;
																			$result = $conn->query($getRank);
																			if($result->num_rows > 0) {
																				while ($row = $result->fetch_assoc()) {
																				$rowpso = $row['position'] + 1;
																					echo $rowpso;
																				}
																			} else {
																				echo $lang['GAMES_PLAYED_WITH_CHAMPRANKONLADDERNOTUPDATED'];
																			}
																		 ?>
																		 </font>
																	 </h4>
																</div>
															</div>
														</div>
													</div>
				                                </div>
			                                </div>
			                            </div>

			                            <div class="masterychampsforsum">
                                            <?php
                                                if ($ranked_champs_info){
	                                                $entriesz = $ranked_champs_info->champions;
	                                                usort($entriesz, function($ac,$bc){
		                                            	return $bc->stats->totalSessionsPlayed-$ac->stats->totalSessionsPlayed;
	                                            	});

                                                foreach ($champs_info as $dataz){
												/* Champion Points */
                                                    $champpoints = $dataz->championPoints;
												/* Champion ID */
                                                    $champid = $dataz->championId;
												/* Champion Mastery Ranking Level */
                                                    $champlevel = $dataz->championLevel;
												/* Last Play Time with Champion OPENS */
                                                    $champplayedtime = $dataz->lastPlayTime;
                                                    $milmastery = $champplayedtime;
                                                    $secondsmastery = $milmastery / 1000;
												/* Last Play Time with Champion CLOSES */
												/* Have you got chest with champion? */
                                                    $champchest = $dataz->chestGranted;
												/* Champion Points until next Mastery Rank Level */
                                                    $champPointsUntilNextLevel = $dataz->championPointsUntilNextLevel;

                                                        echo '<div class="colzz">

			                                                    <div title="'.$lang['TOTAL_CHAMPION_POINTS_EARNED_THIS_CHAMPION_TITLE'].'" class="progress">';
                                                                    if ($champlevel == 1) {
				                                                        echo '<div title="'.$lang['TOTAL_CHAMPION_POINTS_EARNED_THIS_CHAMPION_TITLE'].'" class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:100%">'.$champpoints.' (CP)';
				                                                    }
																	else if ($champlevel == 2){
				                                                        echo '<div title="'.$lang['TOTAL_CHAMPION_POINTS_EARNED_THIS_CHAMPION_TITLE'].'" class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:100%">'.$champpoints.' (CP)';
			                                                        }
																	else if ($champlevel == 3){
				                                                        echo '<div title="'.$lang['TOTAL_CHAMPION_POINTS_EARNED_THIS_CHAMPION_TITLE'].'" class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:100%">'.$champpoints.' (CP)';
			                                                        }
																	else if ($champlevel == 4){
                                                                        echo '<div title="'.$lang['TOTAL_CHAMPION_POINTS_EARNED_THIS_CHAMPION_TITLE'].'" class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:100%">'.$champpoints.' (CP)';
			                                                        }
																	else if ($champlevel == 5){
                                                                        echo '<div title="'.$lang['TOTAL_CHAMPION_POINTS_EARNED_THIS_CHAMPION_TITLE'].'" class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:100%">'.$champpoints.' (CP)';
			                                                        }
				                                               echo '</div>
                                                                </div>

			                                                    <div style="position: relative; width: 195px; height: 195px;">
			                                                        <img width="110px" src="img/champion/'.$champid.'.png" style="position: relative; z-index: 1;"/>';
                                                                        foreach($entriesz as $gazaz){
			                                                                $champsdatazid = $gazaz->id;

			                                                                    if ($champsdatazid == $champid){

				                                                                    if( isset($gazaz->stats) && isset($gazaz->stats->totalChampionKills) ) {
																					/* Champion total kills */
                                                                                        $champsdatazkillz = $gazaz->stats->totalChampionKills;
                                                                                    }
																					else {
				                                                                        $champsdatazkillz = 0;
	                                                                                }

				                                                                    if( isset($gazaz->stats) && isset($gazaz->stats->totalAssists) ) {
																					/* Champion total assists */
                                                                                        $champsdatazassitsz = $gazaz->stats->totalAssists;
                                                                                    }
																					else {
				                                                                        $champsdatazassitsz = 0;
	                                                                                }

				                                                                    if( isset($gazaz->stats) && isset($gazaz->stats->totalDeathsPerSession) ) {
																					/* Champion total deaths */
                                                                                        $champsdatazdeathz = $gazaz->stats->totalDeathsPerSession;
					                                                                }
																					else {
		                                                                                $champsdatazdeathz = 0;
	                                                                                }

																			    /* Champion Games Played */
				                                                                    $champsdatazplayedz = $gazaz->stats->totalSessionsPlayed;
																				/* Champion Games Won Played */
				                                                                    $champstotalSessionsWon = $gazaz->stats->totalSessionsWon;
																				/* Champion Games Lossed Played */
				                                                                    $champstotalSessionsLost = $gazaz->stats->totalSessionsLost;
																				/* Champion Win Rate */
				                                                                    $PercentWinlossratechamps = 100 / ($champstotalSessionsLost + $champstotalSessionsWon) * $champstotalSessionsWon;
																				/* Champion KDA */
				                                                                    $KDAsidechamps = ($champsdatazkillz + $champsdatazassitsz) / $champsdatazdeathz;

				                                                                    echo '<a class="thumbnail" href="#">';

																					if ($champlevel == 1) {
					                                                                    echo '<img width="120px" src="img/mastery/Champ_Mastery_D.png" style="position: absolute; left: -5px; top: -15px; z-index: 2;"/>';
				                                                                    }
																					else if ($champlevel == 2){
					                                                                    echo '<img width="120px" src="img/mastery/Champ_Mastery_C.png" style="position: absolute; left: -5px; top: -15px; z-index: 2;"/>';
				                                                                    }
																					else if ($champlevel == 3){
					                                                                    echo '<img width="120px" src="img/mastery/Champ_Mastery_B.png" style="position: absolute; left: -5px; top: -15px; z-index: 2;"/>';
				                                                                    }
																					else if ($champlevel == 4){
					                                                                    echo '<img width="120px" src="img/mastery/Champ_Mastery_A.png" style="position: absolute; left: -5px; top: -15px; z-index: 2;"/>';
				                                                                    }
																					else if ($champlevel == 5){
					                                                                    echo '<img width="120px" src="img/mastery/Champ_Mastery_S1.png" style="position: absolute; left: -5px; top: -15px; z-index: 2;"/>';
				                                                                    }

																					echo '<span style="background:black; width:160px;">
                                                                                            <b>
																						    <p style="color:#A66D0B; font-size:12px;" align="center">'.$lang['CHAMPION_RANKED_DATA_SEASON6_TITLE'].'</p>
																							</b>
                                                                                            <p style="color:White; font-size:12px;" align="center"><font color="yellow">'.$champsdatazplayedz.'</font> '.$lang['GAMES_PLAYED_WITH_CHAMP_TITLE'].'</p>
                                                                                            <div style="color:White; font-size:12px;" align="center"><font color="green">'.$champstotalSessionsWon.''.$lang['GAMES_PLAYED_WITH_CHAMP_TITLE_W'].'</font> - <font color="red">'.$champstotalSessionsLost.''.$lang['GAMES_PLAYED_WITH_CHAMP_TITLE_L'].'</font></div>
                                                                                            </b>
																							<b>
                                                                                            <p style="color:white; font-size:12px;" align="center">'.$lang['GAMES_PLAYED_WITH_CHAMP_WINRATE'].'</b><font color="#437FC2"> '.number_format((float)$PercentWinlossratechamps, 0, '.', '').'%</font></p>
                                                                                            <b>
																							<p style="color:#967171; font-size:12px;" align="center">'.number_format((float)$KDAsidechamps, 2, '.', '').':1</b> '.$lang['GAMES_PLAYED_WITH_CHAMP_KDA'].'</p>
                                                                                          </span>
																						  </a>';
			                                                                    }
			                                                                    else if ($champsdatazid == NULL) {

		                                                                            echo '<a class="thumbnail" href="#">';

																					if ($champlevel == 1) {
					                                                                    echo '<img width="120px" src="img/mastery/Champ_Mastery_D.png" style="position: absolute; left: -5px; top: -15px; z-index: 2;"/>';
				                                                                    }
																					else if ($champlevel == 2){
					                                                                    echo '<img width="120px" src="img/mastery/Champ_Mastery_C.png" style="position: absolute; left: -5px; top: -15px; z-index: 2;"/>';
				                                                                    }
																					else if ($champlevel == 3){
					                                                                    echo '<img width="120px" src="img/mastery/Champ_Mastery_B.png" style="position: absolute; left: -5px; top: -15px; z-index: 2;"/>';
				                                                                    }
																					else if ($champlevel == 4){
					                                                                    echo '<img width="120px" src="img/mastery/Champ_Mastery_A.png" style="position: absolute; left: -5px; top: -15px; z-index: 2;"/>';
				                                                                    }
																					else if ($champlevel == 5){
					                                                                    echo '<img width="120px" src="img/mastery/Champ_Mastery_S1.png" style="position: absolute; left: -5px; top: -15px; z-index: 2;"/>';
				                                                                    }

																					echo '<span style="background:black; width:160px;">
                                                                                            <b>
																							<p style="color:#A66D0B; font-size:12px;" align="center">'.$lang['CHAMPION_RANKED_DATA_SEASON6_TITLE'].'</p>
																							</b>
                                                                                            <p style="color:White; font-size:12px;" align="center">'.$lang['CHAMPION_RANKED_DATA_SEASON6_NODATA'].'</p>
                                                                                          </span>
																						  </a>';
                                                                                }
		                                                                }

	                                                                    if($champchest == true)
	                                                                    {
		                                                                    echo '<img title="'.$lang['GAMES_PLAYED_WITH_CHAMP_CHEST_TITLE'].'" width="30px" src="img/Hextech_Crafting_Chest.png" style="z-index: 3; position: absolute; left: 76px; top:78px;"/>';
	                                                                    }
																		else {
		                                                                }

	                                                                    echo '<a class="thumbnail" href="#">
																		        <img width="20px" src="img/info-icon.png" style="z-index: 4; position: absolute; left:3.5px; top:4px;"/>
																				<span style="background:black; width:160px;">
	                                                                                <b>
	                                                                                <p style="color:White; font-size:12px;" align="center">'.$lang['GAMES_PLAYED_WITH_CHAMP_GRADE_ACHIEVED'].'</p>
																					</b>';

																					if( isset($dataz->highestGrade)) {
																					/* Champion Highest Grade Earned */
                                                                                        $champhigestgrade = $dataz->highestGrade;

	                                                                                    echo '<p style="color:yellow; font-size:12px;" align="center">'.$champhigestgrade.'</p>';
                                                                                    }
																					else {
	                                                                                    echo '<p style="color:yellow; font-size:12px;" align="center">'.$lang['GAMES_PLAYED_WITH_CHAMP_GRADE_ACHIEVED_IF_NO_GRADE'].'</p>';
                                                                                    }

	                                                                            echo '<br>
																				      <b>
			                                                                          <p style="color:white; font-size:12px;" align="center">'.$lang['GAMES_PLAYED_WITH_CHAMP_LAST_TIME_PLAYED_CHAMPION'].'</p>
			                                                                          </b>
			                                                                          <p style="font-size:12px; color:green;" align="center">'; echo date("d/m/Y, H:i:s", $secondsmastery); echo'</p>
			                                                                          <br>
			                                                                          <b>
			                                                                          <p style="color:white; font-size:12px;" align="center">'.$lang['GAMES_PLAYED_WITH_CHAMP_CHAMPION_POINTS'].'</p>
                                                                                      </b>';

			                                                                        if ($champlevel == 1) {
	                                                                                /* Champion points till rank 2 */
	                                                                                    $champpointsnextrank = 1800-$champpoints;

	                                                                                    echo '<p style="font-size:12px; color:#437FC2;" align="center">'.$lang['GAMES_PLAYED_WITH_CHAMP_YOU_HAVE'].' '.$champpoints.'/1800,  '.$lang['GAMES_PLAYED_WITH_CHAMP_YOU_NEED'].' ('.$champpointsnextrank.' '.$lang['GAMES_PLAYED_WITH_CHAMP_TILL_RANK2'].'</p>';
	                                                                                }
																					else if ($champlevel == 2){
		                                                                            /* Champion points till rank 3 */
		                                                                                $champpointsnextrank = 6000-$champpoints;

	                                                                                    echo '<p style="font-size:12px; color:#437FC2;" align="center">'.$lang['GAMES_PLAYED_WITH_CHAMP_YOU_HAVE'].' '.$champpoints.'/6000,  '.$lang['GAMES_PLAYED_WITH_CHAMP_YOU_NEED'].' ('.$champpointsnextrank.' '.$lang['GAMES_PLAYED_WITH_CHAMP_TILL_RANK3'].'</p>';
	                                                                                }
																					else if ($champlevel == 3){
		                                                                            /* Champion points till rank 4 */
		                                                                                $champpointsnextrank = 12600-$champpoints;

	                                                                                    echo '<p style="font-size:12px; color:#437FC2;" align="center">'.$lang['GAMES_PLAYED_WITH_CHAMP_YOU_HAVE'].' '.$champpoints.'/12600,  '.$lang['GAMES_PLAYED_WITH_CHAMP_YOU_NEED'].' ('.$champpointsnextrank.' '.$lang['GAMES_PLAYED_WITH_CHAMP_TILL_RANK4'].'</p>';
	                                                                                }
																					else if ($champlevel == 4){
		                                                                            /* Champion points till rank 5 */
		                                                                                $champpointsnextrank = 21600-$champpoints;

	                                                                                    echo '<p style="font-size:12px; color:#437FC2;" align="center">'.$lang['GAMES_PLAYED_WITH_CHAMP_YOU_HAVE'].' '.$champpoints.'/21600,  '.$lang['GAMES_PLAYED_WITH_CHAMP_YOU_NEED'].' ('.$champpointsnextrank.' '.$lang['GAMES_PLAYED_WITH_CHAMP_TILL_RANK5'].'</p>';
	                                                                                }
																					else if ($champlevel == 5){
		                                                                            /* Champion points you have as your are rank 5 */
	                                                                                    echo '<p style="font-size:12px; color:#437FC2;" align="center">'.$lang['GAMES_PLAYED_WITH_CHAMP_YOU_HAVE'].' '.$champpoints.'</p>';
	                                                                                }
			                                                                    echo '</span>
																			    </a>
                                                                    </div>
                                                                </div>';
	                                            }
											} else {
												foreach ($champs_info as $dataz){
												/* Champion Points */
                                                    $champpoints = $dataz->championPoints;
												/* Champion ID */
                                                    $champid = $dataz->championId;
												/* Champion Mastery Ranking Level */
                                                    $champlevel = $dataz->championLevel;
												/* Last Play Time with Champion OPENS */
                                                    $champplayedtime = $dataz->lastPlayTime;
                                                    $milmastery = $champplayedtime;
                                                    $secondsmastery = $milmastery / 1000;
												/* Last Play Time with Champion CLOSES */
												/* Have you got chest with champion? */
                                                    $champchest = $dataz->chestGranted;
												/* Champion Points until next Mastery Rank Level */
                                                    $champPointsUntilNextLevel = $dataz->championPointsUntilNextLevel;

                                                        echo '<div class="colzz">

			                                                    <div title="'.$lang['TOTAL_CHAMPION_POINTS_EARNED_THIS_CHAMPION_TITLE'].'" class="progress">';
                                                                    if ($champlevel == 1) {
				                                                        echo '<div title="'.$lang['TOTAL_CHAMPION_POINTS_EARNED_THIS_CHAMPION_TITLE'].'" class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:100%">'.$champpoints.' (CP)';
				                                                    }
																	else if ($champlevel == 2){
				                                                        echo '<div title="'.$lang['TOTAL_CHAMPION_POINTS_EARNED_THIS_CHAMPION_TITLE'].'" class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:100%">'.$champpoints.' (CP)';
			                                                        }
																	else if ($champlevel == 3){
				                                                        echo '<div title="'.$lang['TOTAL_CHAMPION_POINTS_EARNED_THIS_CHAMPION_TITLE'].'" class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:100%">'.$champpoints.' (CP)';
			                                                        }
																	else if ($champlevel == 4){
                                                                        echo '<div title="'.$lang['TOTAL_CHAMPION_POINTS_EARNED_THIS_CHAMPION_TITLE'].'" class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:100%">'.$champpoints.' (CP)';
			                                                        }
																	else if ($champlevel == 5){
                                                                        echo '<div title="'.$lang['TOTAL_CHAMPION_POINTS_EARNED_THIS_CHAMPION_TITLE'].'" class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:100%">'.$champpoints.' (CP)';
			                                                        }
				                                               echo '</div>
                                                                </div>

			                                                    <div style="position: relative; width: 195px; height: 195px;">
			                                                        <img width="110px" src="img/champion/'.$champid.'.png" style="position: relative; z-index: 1;"/>';

                                                                        echo '<a class="thumbnail" href="#">';

																		if ($champlevel == 1) {
		                                                                    echo '<img width="120px" src="img/mastery/Champ_Mastery_D.png" style="position: absolute; left: -5px; top: -15px; z-index: 2;"/>';
	                                                                    }
																		else if ($champlevel == 2){
		                                                                    echo '<img width="120px" src="img/mastery/Champ_Mastery_C.png" style="position: absolute; left: -5px; top: -15px; z-index: 2;"/>';
	                                                                    }
																		else if ($champlevel == 3){
		                                                                    echo '<img width="120px" src="img/mastery/Champ_Mastery_B.png" style="position: absolute; left: -5px; top: -15px; z-index: 2;"/>';
	                                                                    }
																		else if ($champlevel == 4){
		                                                                    echo '<img width="120px" src="img/mastery/Champ_Mastery_A.png" style="position: absolute; left: -5px; top: -15px; z-index: 2;"/>';
	                                                                    }
																		else if ($champlevel == 5){
		                                                                    echo '<img width="120px" src="img/mastery/Champ_Mastery_S1.png" style="position: absolute; left: -5px; top: -15px; z-index: 2;"/>';
	                                                                    }

																		echo '<span style="background:black; width:160px;">
                                                                                <b>
																				<p style="color:#A66D0B; font-size:12px;" align="center">'.$lang['CHAMPION_RANKED_DATA_SEASON6_TITLE'].'</p>
																				</b>
                                                                                <p style="color:White; font-size:12px;" align="center">'.$lang['CHAMPION_RANKED_DATA_SEASON6_NODATA'].'</p>
                                                                              </span>
																			  </a>';

	                                                                    if($champchest == true)
	                                                                    {
		                                                                    echo '<img title="'.$lang['GAMES_PLAYED_WITH_CHAMP_CHEST_TITLE'].'" width="30px" src="img/Hextech_Crafting_Chest.png" style="z-index: 3; position: absolute; left: 76px; top:78px;"/>';
	                                                                    }
																		else {
		                                                                }

	                                                                    echo '<a class="thumbnail" href="#">
																		        <img width="20px" src="img/info-icon.png" style="z-index: 4; position: absolute; left:3.5px; top:4px;"/>
																				<span style="background:black; width:160px;">
	                                                                                <b>
	                                                                                <p style="color:White; font-size:12px;" align="center">'.$lang['GAMES_PLAYED_WITH_CHAMP_GRADE_ACHIEVED'].'</p>
																					</b>';

																					if( isset($dataz->highestGrade)) {
																					/* Champion Highest Grade Earned */
                                                                                        $champhigestgrade = $dataz->highestGrade;

	                                                                                    echo '<p style="color:yellow; font-size:12px;" align="center">'.$champhigestgrade.'</p>';
                                                                                    }
																					else {
	                                                                                    echo '<p style="color:yellow; font-size:12px;" align="center">'.$lang['GAMES_PLAYED_WITH_CHAMP_GRADE_ACHIEVED_IF_NO_GRADE'].'</p>';
                                                                                    }

	                                                                            echo '<br>
																				      <b>
			                                                                          <p style="color:white; font-size:12px;" align="center">'.$lang['GAMES_PLAYED_WITH_CHAMP_LAST_TIME_PLAYED_CHAMPION'].'</p>
			                                                                          </b>
			                                                                          <p style="font-size:12px; color:green;" align="center">'; echo date("d/m/Y, H:i:s", $secondsmastery); echo'</p>
			                                                                          <br>
			                                                                          <b>
			                                                                          <p style="color:white; font-size:12px;" align="center">'.$lang['GAMES_PLAYED_WITH_CHAMP_CHAMPION_POINTS'].'</p>
                                                                                      </b>';

			                                                                        if ($champlevel == 1) {
	                                                                                /* Champion points till rank 2 */
	                                                                                    $champpointsnextrank = 1800-$champpoints;

	                                                                                    echo '<p style="font-size:12px; color:#437FC2;" align="center">'.$lang['GAMES_PLAYED_WITH_CHAMP_YOU_HAVE'].' '.$champpoints.'/1800,  '.$lang['GAMES_PLAYED_WITH_CHAMP_YOU_NEED'].' ('.$champpointsnextrank.' '.$lang['GAMES_PLAYED_WITH_CHAMP_TILL_RANK2'].'</p>';
	                                                                                }
																					else if ($champlevel == 2){
		                                                                            /* Champion points till rank 3 */
		                                                                                $champpointsnextrank = 6000-$champpoints;

	                                                                                    echo '<p style="font-size:12px; color:#437FC2;" align="center">'.$lang['GAMES_PLAYED_WITH_CHAMP_YOU_HAVE'].' '.$champpoints.'/6000,  '.$lang['GAMES_PLAYED_WITH_CHAMP_YOU_NEED'].' ('.$champpointsnextrank.' '.$lang['GAMES_PLAYED_WITH_CHAMP_TILL_RANK3'].'</p>';
	                                                                                }
																					else if ($champlevel == 3){
		                                                                            /* Champion points till rank 4 */
		                                                                                $champpointsnextrank = 12600-$champpoints;

	                                                                                    echo '<p style="font-size:12px; color:#437FC2;" align="center">'.$lang['GAMES_PLAYED_WITH_CHAMP_YOU_HAVE'].' '.$champpoints.'/12600,  '.$lang['GAMES_PLAYED_WITH_CHAMP_YOU_NEED'].' ('.$champpointsnextrank.' '.$lang['GAMES_PLAYED_WITH_CHAMP_TILL_RANK4'].'</p>';
	                                                                                }
																					else if ($champlevel == 4){
		                                                                            /* Champion points till rank 5 */
		                                                                                $champpointsnextrank = 21600-$champpoints;

	                                                                                    echo '<p style="font-size:12px; color:#437FC2;" align="center">'.$lang['GAMES_PLAYED_WITH_CHAMP_YOU_HAVE'].' '.$champpoints.'/21600,  '.$lang['GAMES_PLAYED_WITH_CHAMP_YOU_NEED'].' ('.$champpointsnextrank.' '.$lang['GAMES_PLAYED_WITH_CHAMP_TILL_RANK5'].'</p>';
	                                                                                }
																					else if ($champlevel == 5){
		                                                                            /* Champion points you have as your are rank 5 */
	                                                                                    echo '<p style="font-size:12px; color:#437FC2;" align="center">'.$lang['GAMES_PLAYED_WITH_CHAMP_YOU_HAVE'].' '.$champpoints.'</p>';
	                                                                                }
			                                                                    echo '</span>
																			    </a>
                                                                    </div>
                                                                </div>';
															}
											}
                                            ?>
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
            &copy; 2016 LoLMastery.net  &middot;
		   <a href="about.php">LoLMastery.net isn't endorsed by Riot Games, Inc. League of Legends © Riot Games, Inc.</a>
		    &middot;

		    &middot;

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
                                                                        <td class="Cell ">
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
                                                                        <td class="Cell active">
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
							                                                <a href="index.php?lang=en" class="Link">
							                                                    <div class="Value">English</div>
							                                                </a>
						                                                </td>
																	<!-- ENGLISH LANGUAGE CLOSES -->

																	<!-- FRENCH LANGUAGE OPENS -->
						                                                <td class="Cell ">
							                                                <a href="index.php?lang=fr" class="Link">
							                                                    <div class="Value">Français</div>
							                                                </a>
						                                                </td>
																	<!-- FRENCH LANGUAGE CLOSES -->

																	<!-- GERMAN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="index.php?lang=de" class="Link">
							                                                    <div class="Value">Deutsche</div>
							                                                </a>
						                                                </td>
																	<!-- GERMAN LANGUAGE CLOSES -->

						                                            <!-- POLAND LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="index.php?lang=pl" class="Link">
							                                                    <div class="Value">Polskie</div>
							                                                </a>
						                                                </td>
																	<!-- POLAND LANGUAGE CLOSES -->
					                                                </tr>

					                                                <tr class="Row">
																	<!-- KOREAN LANGUAGE OPENS -->
						                                                <td class="Cell ">
							                                                <a href="index.php?lang=kr" class="Link">
							                                                    <div class="Value">한국어</div>
							                                                </a>
						                                                </td>
																	<!-- KOREAN LANGUAGE CLOSES -->

																	<!-- SWEDISH LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="index.php?lang=se" class="Link">
							                                                    <div class="Value">Svensk</div>
							                                                </a>
						                                                </td>
                                                                    <!-- SWEDISH LANGUAGE CLOSES -->

						                                            <!-- JAPAN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="index.php?lang=ja" class="Link">
							                                                    <div class="Value">日本語</div>
							                                                </a>
						                                                </td>
																	<!-- JAPAN LANGUAGE CLOSES -->

						                                            <!-- SPAIN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="index.php?lang=es" class="Link">
							                                                    <div class="Value">Español</div>
							                                                </a>
						                                                </td>
																	<!-- SPAIN LANGUAGE CLOSES -->
					                                                </tr>

					                                                <tr class="Row">
																	<!-- DANISH LANGUAGE OPENS -->
						                                                <td class="Cell ">
							                                                <a href="index.php?lang=da" class="Link">
							                                                    <div class="Value">Dansk</div>
							                                                </a>
						                                                </td>
																	<!-- DANISH LANGUAGE CLOSES -->

						                                            <!-- ROMANIAN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="index.php?lang=rom" class="Link">
							                                                    <div class="Value">Română</div>
							                                                </a>
						                                                </td>
																	<!-- ROMANIAN LANGUAGE CLOSES -->

						                                            <!-- NORWEGIAN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="index.php?lang=no" class="Link">
							                                                    <div class="Value">Norsk</div>
							                                                </a>
						                                                </td>
																	<!-- NORWEGIAN LANGUAGE CLOSES -->

						                                            <!-- RUSSIAN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="index.php?lang=ru" class="Link">
							                                                    <div class="Value">Pусский</div>
							                                                </a>
						                                                </td>
																	<!-- RUSSIAN LANGUAGE CLOSES -->
					                                                </tr>

                                                                    <tr class="Row">
																	<!-- HUNGARIAN LANGUAGE OPENS -->
						                                                <td class="Cell ">
							                                                <a href="index.php?lang=hu" class="Link">
							                                                    <div class="Value">Magyar</div>
							                                                </a>
						                                                </td>
																	<!-- HUNGARIAN LANGUAGE CLOSES -->

						                                            <!-- FINNISH LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="index.php?lang=fi" class="Link">
							                                                    <div class="Value">Suomalainen</div>
							                                                </a>
						                                                </td>
																	<!-- FINNISH LANGUAGE CLOSES -->

						                                            <!-- TURKISH LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="index.php?lang=tr" class="Link">
							                                                    <div class="Value">Türk</div>
							                                                </a>
						                                                </td>
																	<!-- TURKISH LANGUAGE CLOSES -->

						                                            <!-- SLOVENIAN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="index.php?lang=sl" class="Link">
							                                                    <div class="Value">Slovenski</div>
							                                                </a>
						                                                </td>
																	<!-- SLOVENIAN LANGUAGE CLOSES -->
					                                                </tr>

					                                                <tr class="Row">
																	<!-- PORTUGESE LANGUAGE OPENS -->
						                                                <td class="Cell ">
							                                                <a href="index.php?lang=pt" class="Link">
							                                                    <div class="Value">Português</div>
							                                                </a>
						                                                </td>
																	<!-- PORTUGESE LANGUAGE CLOSES -->

						                                            <!-- CHINESE LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="index.php?lang=zh" class="Link">
							                                                    <div class="Value">中文</div>
							                                                </a>
						                                                </td>
																	<!-- CHINESE LANGUAGE CLOSES -->

						                                            <!-- SERBIAN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="index.php?lang=sr" class="Link">
							                                                    <div class="Value">Српски</div>
							                                                </a>
						                                                </td>
																	<!-- SERBIAN LANGUAGE CLOSES -->

						                                            <!-- ITALIAN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="index.php?lang=it" class="Link">
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

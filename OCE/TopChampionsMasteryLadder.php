<?php
/*
|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
|||||                                                                         |||||
|||||   top_list_creator.php SHOULD BE RAN TO UPDATE THE DATA FOR THIS FILE   |||||
|||||                                                                         |||||
|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
*/
 ?>

﻿<?php
include_once 'common.php';
require_once 'connect_db.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


    <meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
        <head>
            <title><?php echo $lang['TOPCHAMPMASTERYLADDER_HOMEPAGE_TITLE']; ?></title>
            <base >
            <meta charset="utf-8">
            <meta name="description" content="Lookup Champion Mastery Ranking & Mastery Score on our Worldwide Top Ladder.">
            <meta name="keywords" content="league of legends,lol,summoner lookup,game lookup,summoner stats,summoner ranking,skillscore,skill,score,top summoners,champions,summoner stats,champion information,live games,streams,mastery lol,mastery rank,champion mastery">
            <meta name="viewport" content="width=device-width">
            <meta property="og:url" content="TopChampionsMasteryLadder.php">
            <meta property="og:type" content="website">
            <meta property="og:description" content="Lookup Champion Mastery Ranking & Mastery Score on our Worldwide Top Ladder.">
            <meta property="og:site_name" content="LoLMastery">
            <link rel="shortcut icon" href="Favicon.ico" type="image/x-icon">
            <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans|Oswald">
            <link rel="stylesheet" href="css/basetest.css" media="all">
            <link href="css/championladder.css" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="css/top_list_viewer.css" media="screen" title="no title" charset="utf-8">

            <style style="text/css">body{background:#121212;background-image:url(img/background/Background6.jpg);background-size:cover;background-attachment:fixed;background-position:center top;background-repeat:no-repeat;}@media (max-width: 1200px) {body{background-size:initial;}}</style>

            <!-- scripts -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.2.1/mustache.min.js" charset="utf-8"></script>
            <script>
		$(function(){
			var searchInputPast = null;
			$(".SearchInput").on('keyup keydown change', function(){
				var keyword = $(this).val().toLowerCase();
				if (keyword == searchInputPast) {
					return;
				}

				searchInputPast = keyword;

				var allChampions = $(".SelectChampion > .Champion");

				if (keyword.length > 0) {
					var selectedChampions = $(".SelectChampion > .Champion[data-champion-name^='" + keyword + "'],.SelectChampion > .Champion[data-champion-key^='" + keyword + "']");

					allChampions.hide();
					selectedChampions.show();
				} else {
					allChampions.show();
				}
			});
		});
	        </script>
        </head>

        <body>

            <div id="dataProvider" data-static-path="# site main pg" data-current-realm="OCE" data-current-name=""></div>
                <div id="wrapOuter">
                    <nav>
                        <div class="HeaderTools">
					        <dl>
						        <dd class="Region">
							        <a href="#" onclick="showIFrame('#');return false;"><i class='__spSite __spSite-113'></i><?php echo $lang['LANG_TOP']; ?></a>
						    	</dd>
						    </dl>
					    </div>

                        <a href="index.php"><?php echo $lang['NAV_HOME']; ?></a>
			            <a href="Master&Challenger_ChampionPoints.php"><?php echo $lang['NAV_CHALLENGER_MASTER_LADDER']; ?></a>
			            <a href="TopChampionsMasteryLadder.php" style="  display: inline-block;padding: 10px 20px;font-size: 18px;font-weight: normal!important;color: #28b!important;background: #191925;"><?php echo $lang['NAV_CHAMPION_MASTERY_LADDER']; ?></a>
			            <a href="LiveGame.php"><?php echo $lang['NAV_INGAME_INFO']; ?></a>

                        <div class="socialMedia">
                            <div class="fb-like" data-href="<!-- Facebook link -->" data-width="150" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
                        </div>
                    </nav>

                    <div id="wrapContent" class="clearfix">
                        <div class="wrapInner">
                            <div class="wrapInnerMain">
                                <div class="Contentsz center_divz">

                                    <div class="Logoz">
							            <img src="LOLLOGO.png" title="LoLMastery Logo" class="Imagez">
							        </div>

							        <form class="SearchInputz" action="profile.php">
							            <input type="text" name="userName" class="Summonerz" placeholder="<?php echo $lang['SUMMONER_SEARCH_PLACEHOLDER']; ?>">
							            <button class="Buttonz" background-image:url(img/search/loop.png);>
							                <img class="__spSitei216" src="img/search/loop.png"/>
							            </button>
							        </form>
                                    <h1></h1>

                                    <div class="ContentWrap">
				                        <div class="Content">
				                            <div class="Contentzs">
<div class="ChampionRankingLayoutWrap">
	<div class="ChampionRankingLayout">
		<div class="ContentWrap">
			<div class="Content">
				<div class="SideContent">
					<div class="ChampionRankingFilterBox Boxchampladder">
						<div class="SearchChampion">
							<form class="SearchChampionForm" onsubmit="return false;">
								<input type="text" class="SearchInput" placeholder="<?php echo $lang['TOPMASTERYLADDER_CHAMPNAMEPLACEHOLDER']; ?>">
																															</form>
						</div>
						<div class="SelectChampion">

						<div class="Champion " data-champion-name="all" data-champion-key="all">
									<a href="?champion=all" class="Action" id='all'>
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcall imgsizes">All</div>
										</div>
										<div class="ChampionName"><?php echo $lang['TOPMASTERYLADDER_ALL']; ?></div>
									</a>
								</div>

																						<div class="Champion " data-champion-name="aatrox" data-champion-key="aatrox">
									<a href="?champion=266" class="Action" id="266">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcaatrox imgsizes">Aatrox</div>
										</div>
										<div class="ChampionName">Aatrox</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="ahri" data-champion-key="ahri">
									<a href="?champion=103" class="Action" id="103">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcahri imgsizes">Ahri</div>
										</div>
										<div class="ChampionName">Ahri</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="akali" data-champion-key="akali">
									<a href="?champion=84" class="Action" id="84">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcakali imgsizes">Akali</div>
										</div>
										<div class="ChampionName">Akali</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="alistar" data-champion-key="alistar">
									<a href="?champion=12" class="Action" id="12">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcalistar imgsizes">Alistar</div>
										</div>
										<div class="ChampionName">Alistar</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="amumu" data-champion-key="amumu">
									<a href="?champion=32" class="Action" id="32">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcamumu imgsizes">Amumu</div>
										</div>
										<div class="ChampionName">Amumu</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="anivia" data-champion-key="anivia">
									<a href="?champion=34" class="Action" id="34">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcanivia imgsizes">Anivia</div>
										</div>
										<div class="ChampionName">Anivia</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="annie" data-champion-key="annie">
									<a href="?champion=1" class="Action" id="1">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcannie imgsizes">Annie</div>
										</div>
										<div class="ChampionName">Annie</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="ashe" data-champion-key="ashe">
									<a href="?champion=22" class="Action" id="22">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcashe imgsizes">Ashe</div>
										</div>
										<div class="ChampionName">Ashe</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="aurelion sol" data-champion-key="aurelionsol">
									<a href="?champion=136" class="Action" id="136">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcaurelionsol imgsizes">Aurelion Sol</div>
										</div>
										<div class="ChampionName">Aurelion Sol</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="azir" data-champion-key="azir">
									<a href="?champion=268" class="Action" id="268">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcazir imgsizes">Azir</div>
										</div>
										<div class="ChampionName">Azir</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="bard" data-champion-key="bard">
									<a href="?champion=432" class="Action" id="432">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite  __spcbard imgsizes">Bard</div>
										</div>
										<div class="ChampionName">Bard</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="blitzcrank" data-champion-key="blitzcrank">
									<a href="?champion=53" class="Action" id="53">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite  __spcblitzcrank imgsizes">Blitzcrank</div>
										</div>
										<div class="ChampionName">Blitzcrank</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="brand" data-champion-key="brand">
									<a href="?champion=63" class="Action" id="63">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite  __spcbrand imgsizes">Brand</div>
										</div>
										<div class="ChampionName">Brand</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="braum" data-champion-key="braum">
									<a href="?champion=201" class="Action" id="201">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite  __spcbraum imgsizes">Braum</div>
										</div>
										<div class="ChampionName">Braum</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="caitlyn" data-champion-key="caitlyn">
									<a href="?champion=51" class="Action" id="51">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite  __spccaitlyn imgsizes">Caitlyn</div>
										</div>
										<div class="ChampionName">Caitlyn</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="cassiopeia" data-champion-key="cassiopeia">
									<a href="?champion=69" class="Action" id="69">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spccassiopeia imgsizes">Cassiopeia</div>
										</div>
										<div class="ChampionName">Cassiopeia</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="cho&#039;gath" data-champion-key="chogath">
									<a href="?champion=31" class="Action" id="31">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcchogath imgsizes">Cho&#039;Gath</div>
										</div>
										<div class="ChampionName">Cho&#039;Gath</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="corki" data-champion-key="corki">
									<a href="?champion=42" class="Action" id="42">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spccorki imgsizes">Corki</div>
										</div>
										<div class="ChampionName">Corki</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="darius" data-champion-key="darius">
									<a href="?champion=122" class="Action" id="122">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcdarius imgsizes">Darius</div>
										</div>
										<div class="ChampionName">Darius</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="diana" data-champion-key="diana">
									<a href="?champion=131" class="Action" id="131">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcdiana imgsizes">Diana</div>
										</div>
										<div class="ChampionName">Diana</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="dr. mundo" data-champion-key="drmundo">
									<a href="?champion=119" class="Action" id="119">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcdrmundo imgsizes">Dr. Mundo</div>
										</div>
										<div class="ChampionName">Dr. Mundo</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="draven" data-champion-key="draven">
									<a href="?champion=36" class="Action" id="36">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcdraven imgsizes">Draven</div>
										</div>
										<div class="ChampionName">Draven</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="ekko" data-champion-key="ekko">
									<a href="?champion=245" class="Action" id="245">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcekko imgsizes">Ekko</div>
										</div>
										<div class="ChampionName">Ekko</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="elise" data-champion-key="elise">
									<a href="?champion=60" class="Action" id="60">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcelise imgsizes">Elise</div>
										</div>
										<div class="ChampionName">Elise</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="evelynn" data-champion-key="evelynn">
									<a href="?champion=28" class="Action" id="28">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcevelynn imgsizes">Evelynn</div>
										</div>
										<div class="ChampionName">Evelynn</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="ezreal" data-champion-key="ezreal">
									<a href="?champion=81" class="Action" id="81">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcezreal imgsizes">Ezreal</div>
										</div>
										<div class="ChampionName">Ezreal</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="fiddlesticks" data-champion-key="fiddlesticks">
									<a href="?champion=9" class="Action" id="9">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcfiddlesticks imgsizes">Fiddlesticks</div>
										</div>
										<div class="ChampionName">Fiddlesticks</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="fiora" data-champion-key="fiora">
									<a href="?champion=114" class="Action" id="114">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcfiora imgsizes">Fiora</div>
										</div>
										<div class="ChampionName">Fiora</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="fizz" data-champion-key="fizz">
									<a href="?champion=105" class="Action" id="105">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcfizz imgsizes">Fizz</div>
										</div>
										<div class="ChampionName">Fizz</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="galio" data-champion-key="galio">
									<a href="?champion=3" class="Action" id="3">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcgalio imgsizes">Galio</div>
										</div>
										<div class="ChampionName">Galio</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="gangplank" data-champion-key="gangplank">
									<a href="?champion=41" class="Action" id="41">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcgangplank imgsizes">Gangplank</div>
										</div>
										<div class="ChampionName">Gangplank</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="garen" data-champion-key="garen">
									<a href="?champion=86" class="Action" id="86">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcgaren imgsizes">Garen</div>
										</div>
										<div class="ChampionName">Garen</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="gnar" data-champion-key="gnar">
									<a href="?champion=150" class="Action" id="150">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcgnar imgsizes">Gnar</div>
										</div>
										<div class="ChampionName">Gnar</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="gragas" data-champion-key="gragas">
									<a href="?champion=79" class="Action" id="79">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcgragas imgsizes">Gragas</div>
										</div>
										<div class="ChampionName">Gragas</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="graves" data-champion-key="graves">
									<a href="?champion=104" class="Action" id="104">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcgraves imgsizes">Graves</div>
										</div>
										<div class="ChampionName">Graves</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="hecarim" data-champion-key="hecarim">
									<a href="?champion=120" class="Action" id="120">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spchecarim imgsizes">Hecarim</div>
										</div>
										<div class="ChampionName">Hecarim</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="heimerdinger" data-champion-key="heimerdinger">
									<a href="?champion=74" class="Action" id="74">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcheimerdinger imgsizes">Heimerdinger</div>
										</div>
										<div class="ChampionName">Heimerdinger</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="illaoi" data-champion-key="illaoi">
									<a href="?champion=420" class="Action" id="420">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcillaoi imgsizes">Illaoi</div>
										</div>
										<div class="ChampionName">Illaoi</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="irelia" data-champion-key="irelia">
									<a href="?champion=39" class="Action" id="39">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcirelia imgsizes">Irelia</div>
										</div>
										<div class="ChampionName">Irelia</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="janna" data-champion-key="janna">
									<a href="?champion=40" class="Action" id="40">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcjanna imgsizes">Janna</div>
										</div>
										<div class="ChampionName">Janna</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="jarvan iv" data-champion-key="jarvaniv">
									<a href="?champion=59" class="Action" id="59">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcjarvan imgsizes">Jarvan IV</div>
										</div>
										<div class="ChampionName">Jarvan IV</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="jax" data-champion-key="jax">
									<a href="?champion=24" class="Action" id="24">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcjax imgsizes">Jax</div>
										</div>
										<div class="ChampionName">Jax</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="jayce" data-champion-key="jayce">
									<a href="?champion=126" class="Action" id="126">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcjayce imgsizes">Jayce</div>
										</div>
										<div class="ChampionName">Jayce</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="jhin" data-champion-key="jhin">
									<a href="?champion=202" class="Action" id="202">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcjhin imgsizes">Jhin</div>
										</div>
										<div class="ChampionName">Jhin</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="jinx" data-champion-key="jinx">
									<a href="?champion=222" class="Action" id="222">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcjinx imgsizes">Jinx</div>
										</div>
										<div class="ChampionName">Jinx</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="kalista" data-champion-key="kalista">
									<a href="?champion=429" class="Action" id="429">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spckalista imgsizes">Kalista</div>
										</div>
										<div class="ChampionName">Kalista</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="karma" data-champion-key="karma">
									<a href="?champion=43" class="Action" id="43">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spckarma imgsizes">Karma</div>
										</div>
										<div class="ChampionName">Karma</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="karthus" data-champion-key="karthus">
									<a href="?champion=30" class="Action" id="30">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spckarthus imgsizes">Karthus</div>
										</div>
										<div class="ChampionName">Karthus</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="kassadin" data-champion-key="kassadin">
									<a href="?champion=38" class="Action" id="38">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spckassadin imgsizes">Kassadin</div>
										</div>
										<div class="ChampionName">Kassadin</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="katarina" data-champion-key="katarina">
									<a href="?champion=55" class="Action" id="55">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spckatarina imgsizes">Katarina</div>
										</div>
										<div class="ChampionName">Katarina</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="kayle" data-champion-key="kayle">
									<a href="?champion=10" class="Action" id="10">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spckayle imgsizes">Kayle</div>
										</div>
										<div class="ChampionName">Kayle</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="kennen" data-champion-key="kennen">
									<a href="?champion=85" class="Action" id="85">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spckennen imgsizes">Kennen</div>
										</div>
										<div class="ChampionName">Kennen</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="kha&#039;zix" data-champion-key="khazix">
									<a href="?champion=121" class="Action" id="121">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spckhazix imgsizes">Kha&#039;Zix</div>
										</div>
										<div class="ChampionName">Kha&#039;Zix</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="kindred" data-champion-key="kindred">
									<a href="?champion=203" class="Action" id="203">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spckindred imgsizes">Kindred</div>
										</div>
										<div class="ChampionName">Kindred</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="kog&#039;maw" data-champion-key="kogmaw">
									<a href="?champion=96" class="Action" id="96">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spckogmaw imgsizes">Kog&#039;Maw</div>
										</div>
										<div class="ChampionName">Kog&#039;Maw</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="leblanc" data-champion-key="leblanc">
									<a href="?champion=7" class="Action" id="7">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcleblanc imgsizes">LeBlanc</div>
										</div>
										<div class="ChampionName">LeBlanc</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="lee sin" data-champion-key="leesin">
									<a href="?champion=64" class="Action" id="64">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcleesin imgsizes">Lee Sin</div>
										</div>
										<div class="ChampionName">Lee Sin</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="leona" data-champion-key="leona">
									<a href="?champion=89" class="Action" id="89">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcleona imgsizes">Leona</div>
										</div>
										<div class="ChampionName">Leona</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="lissandra" data-champion-key="lissandra">
									<a href="?champion=127" class="Action" id="127">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spclissandra imgsizes">Lissandra</div>
										</div>
										<div class="ChampionName">Lissandra</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="lucian" data-champion-key="lucian">
									<a href="?champion=236" class="Action" id="236">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spclucian imgsizes">Lucian</div>
										</div>
										<div class="ChampionName">Lucian</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="lulu" data-champion-key="lulu">
									<a href="?champion=117" class="Action" id="117">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spclulu imgsizes">Lulu</div>
										</div>
										<div class="ChampionName">Lulu</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="lux" data-champion-key="lux">
									<a href="?champion=99" class="Action" id="99">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spclux imgsizes">Lux</div>
										</div>
										<div class="ChampionName">Lux</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="malphite" data-champion-key="malphite">
									<a href="?champion=54" class="Action" id="54">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcmalphite imgsizes">Malphite</div>
										</div>
										<div class="ChampionName">Malphite</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="malzahar" data-champion-key="malzahar">
									<a href="?champion=90" class="Action" id="90">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcmalzahar imgsizes">Malzahar</div>
										</div>
										<div class="ChampionName">Malzahar</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="maokai" data-champion-key="maokai">
									<a href="?champion=57" class="Action" id="57">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcmaokai imgsizes">Maokai</div>
										</div>
										<div class="ChampionName">Maokai</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="master yi" data-champion-key="masteryi">
									<a href="?champion=11" class="Action" id="11">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcmasteryi imgsizes">Master Yi</div>
										</div>
										<div class="ChampionName">Master Yi</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="miss fortune" data-champion-key="missfortune">
									<a href="?champion=21" class="Action" id="21">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcmissfortune imgsizes">Miss Fortune</div>
										</div>
										<div class="ChampionName">Miss Fortune</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="mordekaiser" data-champion-key="mordekaiser">
									<a href="?champion=82" class="Action" id="82">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcmordekaiser imgsizes">Mordekaiser</div>
										</div>
										<div class="ChampionName">Mordekaiser</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="morgana" data-champion-key="morgana">
									<a href="?champion=25" class="Action" id="25">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcmorgana imgsizes">Morgana</div>
										</div>
										<div class="ChampionName">Morgana</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="nami" data-champion-key="nami">
									<a href="?champion=267" class="Action" id="267">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcnami imgsizes">Nami</div>
										</div>
										<div class="ChampionName">Nami</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="nasus" data-champion-key="nasus">
									<a href="?champion=75" class="Action" id="75">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcnasus imgsizes">Nasus</div>
										</div>
										<div class="ChampionName">Nasus</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="nautilus" data-champion-key="nautilus">
									<a href="?champion=111" class="Action" id="111">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcnautilus imgsizes">Nautilus</div>
										</div>
										<div class="ChampionName">Nautilus</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="nidalee" data-champion-key="nidalee">
									<a href="?champion=76" class="Action" id="76">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcnidalee imgsizes">Nidalee</div>
										</div>
										<div class="ChampionName">Nidalee</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="nocturne" data-champion-key="nocturne">
									<a href="?champion=56" class="Action" id="56">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcnocturne imgsizes">Nocturne</div>
										</div>
										<div class="ChampionName">Nocturne</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="nunu" data-champion-key="nunu">
									<a href="?champion=20" class="Action" id="20">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcnunu imgsizes">Nunu</div>
										</div>
										<div class="ChampionName">Nunu</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="olaf" data-champion-key="olaf">
									<a href="?champion=2" class="Action" id="2">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcolaf imgsizes">Olaf</div>
										</div>
										<div class="ChampionName">Olaf</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="orianna" data-champion-key="orianna">
									<a href="?champion=61" class="Action" id="61">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcorianna imgsizes">Orianna</div>
										</div>
										<div class="ChampionName">Orianna</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="pantheon" data-champion-key="pantheon">
									<a href="?champion=80" class="Action" id="80">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcpantheon imgsizes">Pantheon</div>
										</div>
										<div class="ChampionName">Pantheon</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="poppy" data-champion-key="poppy">
									<a href="?champion=78" class="Action" id="78">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcpoppy imgsizes">Poppy</div>
										</div>
										<div class="ChampionName">Poppy</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="quinn" data-champion-key="quinn">
									<a href="?champion=133" class="Action" id="133">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcquinn imgsizes">Quinn</div>
										</div>
										<div class="ChampionName">Quinn</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="rammus" data-champion-key="rammus">
									<a href="?champion=33" class="Action" id="33">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcrammus imgsizes">Rammus</div>
										</div>
										<div class="ChampionName">Rammus</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="rek&#039;sai" data-champion-key="reksai">
									<a href="?champion=421" class="Action" id="421">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcreksai imgsizes">Rek&#039;Sai</div>
										</div>
										<div class="ChampionName">Rek&#039;Sai</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="renekton" data-champion-key="renekton">
									<a href="?champion=58" class="Action" id="58">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcrenekton imgsizes">Renekton</div>
										</div>
										<div class="ChampionName">Renekton</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="rengar" data-champion-key="rengar">
									<a href="?champion=107" class="Action" id="107">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcrengar imgsizes">Rengar</div>
										</div>
										<div class="ChampionName">Rengar</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="riven" data-champion-key="riven">
									<a href="?champion=92" class="Action" id="92">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcriven imgsizes">Riven</div>
										</div>
										<div class="ChampionName">Riven</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="rumble" data-champion-key="rumble">
									<a href="?champion=68" class="Action" id="68">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcrumble imgsizes">Rumble</div>
										</div>
										<div class="ChampionName">Rumble</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="ryze" data-champion-key="ryze">
									<a href="?champion=13" class="Action" id="13">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcryze imgsizes">Ryze</div>
										</div>
										<div class="ChampionName">Ryze</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="sejuani" data-champion-key="sejuani">
									<a href="?champion=113" class="Action" id="113">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcsejuani imgsizes">Sejuani</div>
										</div>
										<div class="ChampionName">Sejuani</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="shaco" data-champion-key="shaco">
									<a href="?champion=35" class="Action" id="35">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcshaco imgsizes">Shaco</div>
										</div>
										<div class="ChampionName">Shaco</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="shen" data-champion-key="shen">
									<a href="?champion=98" class="Action" id="98">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcshen imgsizes">Shen</div>
										</div>
										<div class="ChampionName">Shen</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="shyvana" data-champion-key="shyvana">
									<a href="?champion=102" class="Action" id="102">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcshyvana imgsizes">Shyvana</div>
										</div>
										<div class="ChampionName">Shyvana</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="singed" data-champion-key="singed">
									<a href="?champion=27" class="Action" id="27">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcsinged imgsizes">Singed</div>
										</div>
										<div class="ChampionName">Singed</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="sion" data-champion-key="sion">
									<a href="?champion=14" class="Action" id="14">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcsion imgsizes">Sion</div>
										</div>
										<div class="ChampionName">Sion</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="sivir" data-champion-key="sivir">
									<a href="?champion=15" class="Action" id="15">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcsivir imgsizes">Sivir</div>
										</div>
										<div class="ChampionName">Sivir</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="skarner" data-champion-key="skarner">
									<a href="?champion=72" class="Action" id="72">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcskarner imgsizes">Skarner</div>
										</div>
										<div class="ChampionName">Skarner</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="sona" data-champion-key="sona">
									<a href="?champion=37" class="Action" id="37">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcsona imgsizes">Sona</div>
										</div>
										<div class="ChampionName">Sona</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="soraka" data-champion-key="soraka">
									<a href="?champion=16" class="Action" id="16">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcsoraka imgsizes">Soraka</div>
										</div>
										<div class="ChampionName">Soraka</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="swain" data-champion-key="swain">
									<a href="?champion=50" class="Action" id="50">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcswain imgsizes">Swain</div>
										</div>
										<div class="ChampionName">Swain</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="syndra" data-champion-key="syndra">
									<a href="?champion=134" class="Action" id="134">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcsyndra imgsizes">Syndra</div>
										</div>
										<div class="ChampionName">Syndra</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="tahm kench" data-champion-key="tahmkench">
									<a href="?champion=223" class="Action" id="223">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spctahmkench imgsizes">Tahm Kench</div>
										</div>
										<div class="ChampionName">Tahm Kench</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="talon" data-champion-key="talon">
									<a href="?champion=91" class="Action" id="91">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spctalon imgsizes">Talon</div>
										</div>
										<div class="ChampionName">Talon</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="taric" data-champion-key="taric">
									<a href="?champion=44" class="Action" id="44">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spctaric imgsizes">Taric</div>
										</div>
										<div class="ChampionName">Taric</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="teemo" data-champion-key="teemo">
									<a href="?champion=17" class="Action" id="17">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcteemo imgsizes">Teemo</div>
										</div>
										<div class="ChampionName">Teemo</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="thresh" data-champion-key="thresh">
									<a href="?champion=412" class="Action" id="412">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcthresh imgsizes">Thresh</div>
										</div>
										<div class="ChampionName">Thresh</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="tristana" data-champion-key="tristana">
									<a href="?champion=18" class="Action" id="18">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spctristana imgsizes">Tristana</div>
										</div>
										<div class="ChampionName">Tristana</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="trundle" data-champion-key="trundle">
									<a href="?champion=48" class="Action" id="48">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spctrundle imgsizes">Trundle</div>
										</div>
										<div class="ChampionName">Trundle</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="tryndamere" data-champion-key="tryndamere">
									<a href="?champion=23" class="Action" id="23">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spctryndamere imgsizes">Tryndamere</div>
										</div>
										<div class="ChampionName">Tryndamere</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="twisted fate" data-champion-key="twistedfate">
									<a href="?champion=4" class="Action" id="4">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spctwistedfate imgsizes">Twisted Fate</div>
										</div>
										<div class="ChampionName">Twisted Fate</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="twitch" data-champion-key="twitch">
									<a href="?champion=29" class="Action" id="29">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spctwitch imgsizes">Twitch</div>
										</div>
										<div class="ChampionName">Twitch</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="udyr" data-champion-key="udyr">
									<a href="?champion=77" class="Action" id="77">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcudyr imgsizes">Udyr</div>
										</div>
										<div class="ChampionName">Udyr</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="urgot" data-champion-key="urgot">
									<a href="?champion=6" class="Action" id="6">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcurgot imgsizes">Urgot</div>
										</div>
										<div class="ChampionName">Urgot</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="varus" data-champion-key="varus">
									<a href="?champion=110" class="Action" id="110">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcvarus imgsizes">Varus</div>
										</div>
										<div class="ChampionName">Varus</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="vayne" data-champion-key="vayne">
									<a href="?champion=67" class="Action" id="67">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcvayne imgsizes">Vayne</div>
										</div>
										<div class="ChampionName">Vayne</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="veigar" data-champion-key="veigar">
									<a href="?champion=45" class="Action" id="45">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcveigar imgsizes">Veigar</div>
										</div>
										<div class="ChampionName">Veigar</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="vel&#039;koz" data-champion-key="velkoz">
									<a href="?champion=161" class="Action" id="161">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcvelkoz imgsizes">Vel&#039;Koz</div>
										</div>
										<div class="ChampionName">Vel&#039;Koz</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="vi" data-champion-key="vi">
									<a href="?champion=254" class="Action" id="254">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcvi imgsizes">Vi</div>
										</div>
										<div class="ChampionName">Vi</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="viktor" data-champion-key="viktor">
									<a href="?champion=112" class="Action" id="112">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcviktor imgsizes">Viktor</div>
										</div>
										<div class="ChampionName">Viktor</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="vladimir" data-champion-key="vladimir">
									<a href="?champion=8" class="Action" id="8">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcvladimir imgsizes">Vladimir</div>
										</div>
										<div class="ChampionName">Vladimir</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="volibear" data-champion-key="volibear">
									<a href="?champion=106" class="Action" id="106">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcvolibear imgsizes">Volibear</div>
										</div>
										<div class="ChampionName">Volibear</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="warwick" data-champion-key="warwick">
									<a href="?champion=19" class="Action" id="19">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcwarwick imgsizes">Warwick</div>
										</div>
										<div class="ChampionName">Warwick</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="wukong" data-champion-key="monkeyking">
									<a href="?champion=62" class="Action" id="62">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcwukong imgsizes">Wukong</div>
										</div>
										<div class="ChampionName">Wukong</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="xerath" data-champion-key="xerath">
									<a href="?champion=101" class="Action" id="101">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcxerath imgsizes">Xerath</div>
										</div>
										<div class="ChampionName">Xerath</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="xin zhao" data-champion-key="xinzhao">
									<a href="?champion=5" class="Action" id="5">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcxinzhao imgsizes">Xin Zhao</div>
										</div>
										<div class="ChampionName">Xin Zhao</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="yasuo" data-champion-key="yasuo">
									<a href="?champion=157" class="Action" id="157">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcyasuo imgsizes">Yasuo</div>
										</div>
										<div class="ChampionName">Yasuo</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="yorick" data-champion-key="yorick">
									<a href="?champion=83" class="Action" id="83">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcyorick imgsizes">Yorick</div>
										</div>
										<div class="ChampionName">Yorick</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="zac" data-champion-key="zac">
									<a href="?champion=154" class="Action" id="154">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spczac imgsizes">Zac</div>
										</div>
										<div class="ChampionName">Zac</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="zed" data-champion-key="zed">
									<a href="?champion=238" class="Action" id="238">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spczed imgsizes">Zed</div>
										</div>
										<div class="ChampionName">Zed</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="ziggs" data-champion-key="ziggs">
									<a href="?champion=115" class="Action" id="115">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spcziggs imgsizes">Ziggs</div>
										</div>
										<div class="ChampionName">Ziggs</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="zilean" data-champion-key="zilean">
									<a href="?champion=26" class="Action" id="26">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spczilean imgsizes">Zilean</div>
										</div>
										<div class="ChampionName">Zilean</div>
									</a>
								</div>
															<div class="Champion " data-champion-name="zyra" data-champion-key="zyra">
									<a href="?champion=143" class="Action" id="143">
										<div class="ChampionImage">
											<div class="selected"></div>
											<div class="Image __sprite __spczyra imgsizes">Zyra</div>
										</div>
										<div class="ChampionName">Zyra</div>
									</a>
								</div>
													</div>
					</div>
				</div>

				<div class="RealContent">
						<div id="ChampionRankingUpdateArea" disabled="disabled"><div class="ChampionRankingBox Box">
	<h2 class="Title">


		<?php

		if(isset($_GET['champion'])) {

			if($_GET['champion'] == 'all' || $_GET['champion'] == '') {
				echo '<img src="img/lollogo.jpg" class="ChampionImage" alt="Title"> &nbsp; <b>'.$lang['TOPMASTERYLADDER_BOXTITLE'].'</b>';
			} else {
				echo '<img src="img/champion/'.$_GET['champion'].'.png" class="ChampionImage" alt="Title"> &nbsp; <b>'.$lang['TOPMASTERYLADDER_BOXTITLE'].'</b>';
			}

			if(isset($_GET['page'])) {
				echo '<a href="?champion='.$_GET['champion'].'&page='.((int)$_GET['page']-1).'"><button class="championpageprev">'.$lang['TOPMASTERYLADDER_PREV'].'</button></a>
				<a href="?champion='.$_GET['champion'].'&page='.((int)$_GET['page']+1).'"><button class="championpagenext">'.$lang['TOPMASTERYLADDER_NEXT'].'</button></a>';
			} else {
				echo '<a href="?champion='.$_GET['champion'].'&page=0"><button class="championpageprev">'.$lang['TOPMASTERYLADDER_PREV'].'</button></a>
				<a href="?champion='.$_GET['champion'].'&page=1"><button class="championpagenext">'.$lang['TOPMASTERYLADDER_NEXT'].'</button></a>';
			}
		} else {
			echo '<img src="img/lollogo.jpg" class="ChampionImage" alt="Title"> &nbsp; <b>'.$lang['TOPMASTERYLADDER_BOXTITLE'].'</b>';

			if(isset($_GET['page'])) {
				echo '<a href="?page='.((int)$_GET['page']-1).'"><button class="championpageprev">'.$lang['TOPMASTERYLADDER_PREV'].'</button></a>
				<a href="?page='.((int)$_GET['page']+1).'"><button class="championpagenext">'.$lang['TOPMASTERYLADDER_NEXT'].'</button></a>';
			} else {
				echo '<a href="?page=0"><button class="championpageprev">'.$lang['TOPMASTERYLADDER_PREV'].'</button></a>
				<a href="?page=1"><button class="championpagenext">'.$lang['TOPMASTERYLADDER_NEXT'].'</button></a>';
			}
		}

		 ?>

	</h2>
		<!-- <div class="tableWrapper"> -->
	<table class="Table">
		<colgroup>
			<col width="42">
			<col width="34">
			<col width="140">
			<col width="28">
			<col width="100">
			<col width="80">
			<col width="120">

		</colgroup>
		<tbody class="Body" id='tbody'>

			<?php
			if(isset($_GET['champion'])) {
				if($_GET['champion'] == '' || $_GET['champion'] == 'all') {
					$sql = "SELECT * FROM top_list_OSCA ORDER BY position ASC";
						echo "<script type='text/javascript'>
							$(function() {
									 $('a#all').parent().addClass('selected');
								});
								console.log()
							</script>";
				} else {

					echo "<script type='text/javascript'>
						$(function() {
								 $('a#".$_GET['champion']."').parent().addClass('selected');
							});
							console.log()
						</script>";
					$sql = "SELECT * FROM top_list_OSCA WHERE champ_id = ".$_GET['champion']." ORDER BY position ASC";
				}
			} else {

				echo "<script type='text/javascript'>
					$(function() {
							 $('a#all').parent().addClass('selected');
						});
						console.log()
					</script>";
				$sql = "SELECT * FROM top_list_OSCA ORDER BY position ASC";
			}
			$result = $conn->query($sql);
            if($result && $result->num_rows > 0) {
				$playersByCP = array();
				while ($row = $result->fetch_assoc()) {
					array_push($playersByCP, unserialize($row['table_row']));
				}
				for ($i=0; $i < 60; $i++) {
					if (isset($_GET['page'])) {
						if(isset($playersByCP[$i+60*$_GET['page']])) {

							$playerByCP = $playersByCP[$i+60*$_GET['page']];

							if($_GET['champion'] == 'all' || $_GET['champion'] == '') {
								$img = 'img/champion/'.$playerByCP['champId'];
							} else {
								$img = 'http://ddragon.leagueoflegends.com/cdn/6.9.1/img/profileicon/'.$playerByCP['profileiconid'];
							}

							echo '<tr class="Row" id="row_'.$playerByCP['champId'].'">
								<td class="Rank Cell index">'.($i+60*$_GET['page']+1).'</td>
								<td class="championimg Cell">
									<a href="profile.php?userName='.$playerByCP['playerName'].'" class="Link" target="_blank">
										<img src="'.$img.'.png" class="Image"></a>
								</td>
								<td class="SummonerName Cell">
									<a href="profile.php?userName='.$playerByCP['playerName'].'" class="Link" target="_blank">'.$playerByCP['playerName'].'</a>
								</td>
								<td class="TierMedal Cell">
									<img src="img/tiers/'.strtolower($playerByCP['tier']).'_'.strtolower($playerByCP['division']).'.png" class="Image">
								</td>
								<td title="'.$lang['TOPMASTERYLADDER_TIERRANK'].'" class="TierRank Cell">
									'.$playerByCP['tier'].' '.$playerByCP['division'].'
								</td>
								<td title="'.$lang['TOPMASTERYLADDER_CHAMPGRADE'].'" class="MasteryRank Cell">
									'.$playerByCP['highestGrade'].'
								</td>
								<td title="'.$lang['TOPMASTERYLADDER_CHAMPPOINTS'].'" class="MasteryChampionPoints Cell">
									'.$playerByCP['championPoints'].' (CP)					</td>
							</tr>';
						}
					} else {
						if(isset($playersByCP[$i])) {
							$playerByCP = $playersByCP[$i];

							if($_GET['champion'] == 'all' || $_GET['champion'] == '') {
								$img = 'img/champion/'.$playerByCP['champId'];
							} else {
								$img = 'http://ddragon.leagueoflegends.com/cdn/6.9.1/img/profileicon/'.$playerByCP['profileiconid'];
							}

							echo '<tr class="Row" id="row_'.$playerByCP['champId'].'">
								<td class="Rank Cell index">'.($i+1).'</td>
								<td class="championimg Cell">
									<a href="profile.php?userName='.$playerByCP['playerName'].'" class="Link" target="_blank">

										<img src="'.$img.'.png" class="Image"></a>
								</td>
								<td class="SummonerName Cell">
									<a href="profile.php?userName='.$playerByCP['playerName'].'" class="Link" target="_blank">'.$playerByCP['playerName'].'</a>
								</td>
								<td class="TierMedal Cell">
									<img src="img/tiers/'.strtolower($playerByCP['tier']).'_'.strtolower($playerByCP['division']).'.png" class="Image">
								</td>
								<td title="'.$lang['TOPMASTERYLADDER_TIERRANK'].'" class="TierRank Cell">
									'.$playerByCP['tier'].' '.$playerByCP['division'].'
								</td>
								<td title="'.$lang['TOPMASTERYLADDER_CHAMPGRADE'].'" class="MasteryRank Cell">
									'.$playerByCP['highestGrade'].'
								</td>
								<td title="'.$lang['TOPMASTERYLADDER_CHAMPPOINTS'].'" class="MasteryChampionPoints Cell">
									'.$playerByCP['championPoints'].' (CP)					</td>
							</tr>';
						}
					}
				}
			} else {
				echo '<h1>No champion with name: '.$_GET['champion'].'</h1>';
			}

			 ?>

										</tbody>
									</table>
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
</div></div>



<footer>
<div class="wrapInner">
&copy; 2016 LoLMastery.net  &middot;<a href="about.php">LoLMastery.net isn't endorsed by Riot Games, Inc. League of Legends © Riot Games, Inc.</a> &middot;  &middot;  &middot;
<div class="socialMedia">
<a href="#"><img src="img/social/twitter.png" alt="Twitter"></a>
<a href="#"><img src="img/social/facebook.png" alt="Facebook"></a>
</div>
</div>
</footer>

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
                                                                        <td class="Cell active">
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
							                                                <a href="TopChampionsMasteryLadder.php?lang=en" class="Link">
							                                                    <div class="Value">English</div>
							                                                </a>
						                                                </td>
																	<!-- ENGLISH LANGUAGE CLOSES -->

																	<!-- FRENCH LANGUAGE OPENS -->
						                                                <td class="Cell ">
							                                                <a href="TopChampionsMasteryLadder.php?lang=fr" class="Link">
							                                                    <div class="Value">Français</div>
							                                                </a>
						                                                </td>
																	<!-- FRENCH LANGUAGE CLOSES -->

																	<!-- GERMAN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="TopChampionsMasteryLadder.php?lang=de" class="Link">
							                                                    <div class="Value">Deutsche</div>
							                                                </a>
						                                                </td>
																	<!-- GERMAN LANGUAGE CLOSES -->

						                                            <!-- POLAND LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="TopChampionsMasteryLadder.php?lang=pl" class="Link">
							                                                    <div class="Value">Polskie</div>
							                                                </a>
						                                                </td>
																	<!-- POLAND LANGUAGE CLOSES -->
					                                                </tr>

					                                                <tr class="Row">
																	<!-- KOREAN LANGUAGE OPENS -->
						                                                <td class="Cell ">
							                                                <a href="TopChampionsMasteryLadder.php?lang=kr" class="Link">
							                                                    <div class="Value">한국어</div>
							                                                </a>
						                                                </td>
																	<!-- KOREAN LANGUAGE CLOSES -->

																	<!-- SWEDISH LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="TopChampionsMasteryLadder.php?lang=se" class="Link">
							                                                    <div class="Value">Svensk</div>
							                                                </a>
						                                                </td>
                                                                    <!-- SWEDISH LANGUAGE CLOSES -->

						                                            <!-- JAPAN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="TopChampionsMasteryLadder.php?lang=ja" class="Link">
							                                                    <div class="Value">日本語</div>
							                                                </a>
						                                                </td>
																	<!-- JAPAN LANGUAGE CLOSES -->

						                                            <!-- SPAIN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="TopChampionsMasteryLadder.php?lang=es" class="Link">
							                                                    <div class="Value">Español</div>
							                                                </a>
						                                                </td>
																	<!-- SPAIN LANGUAGE CLOSES -->
					                                                </tr>

					                                                <tr class="Row">
																	<!-- DANISH LANGUAGE OPENS -->
						                                                <td class="Cell ">
							                                                <a href="TopChampionsMasteryLadder.php?lang=da" class="Link">
							                                                    <div class="Value">Dansk</div>
							                                                </a>
						                                                </td>
																	<!-- DANISH LANGUAGE CLOSES -->

						                                            <!-- ROMANIAN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="TopChampionsMasteryLadder.php?lang=rom" class="Link">
							                                                    <div class="Value">Română</div>
							                                                </a>
						                                                </td>
																	<!-- ROMANIAN LANGUAGE CLOSES -->

						                                            <!-- NORWEGIAN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="TopChampionsMasteryLadder.php?lang=no" class="Link">
							                                                    <div class="Value">Norsk</div>
							                                                </a>
						                                                </td>
																	<!-- NORWEGIAN LANGUAGE CLOSES -->

						                                            <!-- RUSSIAN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="TopChampionsMasteryLadder.php?lang=ru" class="Link">
							                                                    <div class="Value">Pусский</div>
							                                                </a>
						                                                </td>
																	<!-- RUSSIAN LANGUAGE CLOSES -->
					                                                </tr>

                                                                    <tr class="Row">
																	<!-- HUNGARIAN LANGUAGE OPENS -->
						                                                <td class="Cell ">
							                                                <a href="TopChampionsMasteryLadder.php?lang=hu" class="Link">
							                                                    <div class="Value">Magyar</div>
							                                                </a>
						                                                </td>
																	<!-- HUNGARIAN LANGUAGE CLOSES -->

						                                            <!-- FINNISH LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="TopChampionsMasteryLadder.php?lang=fi" class="Link">
							                                                    <div class="Value">Suomalainen</div>
							                                                </a>
						                                                </td>
																	<!-- FINNISH LANGUAGE CLOSES -->

						                                            <!-- TURKISH LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="TopChampionsMasteryLadder.php?lang=tr" class="Link">
							                                                    <div class="Value">Türk</div>
							                                                </a>
						                                                </td>
																	<!-- TURKISH LANGUAGE CLOSES -->

						                                            <!-- SLOVENIAN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="TopChampionsMasteryLadder.php?lang=sl" class="Link">
							                                                    <div class="Value">Slovenski</div>
							                                                </a>
						                                                </td>
																	<!-- SLOVENIAN LANGUAGE CLOSES -->
					                                                </tr>

					                                                <tr class="Row">
																	<!-- PORTUGESE LANGUAGE OPENS -->
						                                                <td class="Cell ">
							                                                <a href="TopChampionsMasteryLadder.php?lang=pt" class="Link">
							                                                    <div class="Value">Português</div>
							                                                </a>
						                                                </td>
																	<!-- PORTUGESE LANGUAGE CLOSES -->

						                                            <!-- CHINESE LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="TopChampionsMasteryLadder.php?lang=zh" class="Link">
							                                                    <div class="Value">中文</div>
							                                                </a>
						                                                </td>
																	<!-- CHINESE LANGUAGE CLOSES -->

						                                            <!-- SERBIAN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="TopChampionsMasteryLadder.php?lang=sr" class="Link">
							                                                    <div class="Value">Српски</div>
							                                                </a>
						                                                </td>
																	<!-- SERBIAN LANGUAGE CLOSES -->

						                                            <!-- ITALIAN LANGUAGE OPENS -->
																	    <td class="Cell ">
							                                                <a href="TopChampionsMasteryLadder.php?lang=it" class="Link">
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

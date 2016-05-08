<?php
	include_once 'common.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">

<head> <!-- HEAD OPENS -->
    <title><?php echo $lang['404_title']; ?></title> <!-- Page Title -->
    <meta charset="utf-8">
    <meta name="description" content="Lookup League of Legends summoner mastery data, analyse summoners and strive to become the world's best player with your favourite champions in our ladder">
    <meta name="keywords" content="league of legends,lol,summoner lookup,game lookup,summoner stats,summoner ranking,skill,score,top summoners,champions,summoner stats,champion information,live games,streams, lol masterys, champion mastery">
    <meta name="viewport" content="width=device-width">
    <meta property="og:type" content="website">
    <meta property="og:title" content="League of Legends Game &amp; Summoner Mastery Lookup">
    <meta property="og:locale" content="en_GB">
    <meta property="og:description" content="Lookup your Champion Mastery's and aim to become the best with those champions with our ladder!">
    <meta property="og:site_name" content="Champion Mastery Checker">
    <link rel="shortcut icon" href="Favicon.ico" type="image/x-icon"> <!-- ICON -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans|Oswald">

    <link rel="stylesheet" href="css/basetest.css" media="all"> <!-- Base CSS for the entire site -->
    <link href="css/summoner87f5.css" rel="stylesheet" type="text/css"> <!-- CSS for profile page -->

    <style style="text/css">body{background:#121212;background-image:url(img/background/Background6.jpg);background-size:100% auto;background-attachment:fixed;background-position:center top;background-repeat:no-repeat;}@media (max-width: 1200px) {body{background-size:initial;}}</style>

</head> <!-- HEAD CLOSES -->

<body> <!-- BODY OPENS -->


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
					        <div id="ExtraView"></div>
					            <div class="ContentWrap tabItems" id="SummonerLayoutContent">
								    <div class="tabItem Content SummonerLayoutContent summonerLayout-summary" data-tab-spinner-height="800" data-tab-is-loaded-already="true">
									    <div class="Box1" align="center" style="vertical-align:middle;">
										    <div align="center" style="margin-top:40px;">
									            <img src="img/0009bf1282fb014e65049b135397640d.png" width="350px"/>
											    <img src="img/404.png" />
                                            </div>

                                            <div align="center" style="margin-top:80px;">
											    <h3><?php echo $lang['404_TOP']; ?></h3>
											    <br>
											    <h3><?php echo $lang['404_Bot']; ?></h3>
											    <br>
											    <br>
											    <br>
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
            &copy; 2016 LoLMastery.ff &middot;
		   <a href="about.php">LoLMastery.ff isn't endorsed by Riot Games, Inc. League of Legends © Riot Games, Inc.</a>
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
																		<td class="Cell active">
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

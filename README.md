# LoLMastery.net - RiotAPI-Challenger-2016-May

THIS REPOSITORY IS FOR A RIOT API CHALLENGE ENTRY AND THE DATA IS PROVIDED BY RIOT AND ONLY RIOT. ANY DATA STORED IN OUR DATABASE IS FOR US AND US ONLY.

FOR A LIVE DEMO GO TO http://amazonsaver.uk/

With LoLMastery.net everybody can access anybody's data about their champion masteries with full detail, in addition to that it also shows their ranked info with every champion they have played and their ranked status. You can also find a top list which is sorted by highest champion points, separate from that there is a master and challenger top list with their champion points and mastery scores so players can compare there mastery stats to top ranked players.

We also include a live game checker, that checks to see if a player is in game and will get all information about enemy and your own team, it provides ranked data and mastery data.

Also the web is accessible from multiple regions and languages, we also include a function that saves in your cookies the latest server and language the user used, so next time the user loads the site, it will open on same server and language that the user was using before.

The 10 Servers our website provides access to the users are:
- BR
- EUNE
- EUW
- KR
- LAN
- LAS
- OCE
- NA
- RU
- TR

WEBSITES MAIN LANGUAGE IS IN ENGLISH
The 20 Languages our website offer to the users are:
- English
- Danish
- German
- Spanish
- Finnish
- French
- Hungarian
- Italian
- Japanese
- Korean
- Norwegian
- Polish
- Portuguese
- Romanian
- Russian
- Swedish
- Slovenian
- Serbian
- Turkish
- Chinese


To build this website we used 4 programming languages, HTML, PHP, CSS and JAVASCRIPT.

All data is stored in a database that is only used for LoLMastery.net and automatically updates data when a user updates their profile.

In order to make the code work you need MySQL database with server connection collation and database collation set as utf8_bin. The database must contain the tables shown in "/tables_1.jpg" with their settings.

![alt tag](https://raw.githubusercontent.com/TheHHG7/RiotAPI-Challenger-2016-May/master/tables_1.jpg)

The settings for the tables challengerandmaster_data, challengerandmaster_data_KR, challengerandmaster_data_BR, challengerandmaster_data_TR, challengerandmaster_data_EUNE, challengerandmaster_data_LAN, challengerandmaster_data_LAS, challengerandmaster_data_NA, challengerandmaster_data_OSCA, challengerandmaster_data_RU, players_data, players_data_BR, players_data_EUNE, players_data_KR, players_data_LAN, players_data_LAN, players_data_NA, players_data_OSCA, players_data_RU, players_data_TR are shown in "/coloumn_1.jpg".

![alt tag](https://raw.githubusercontent.com/TheHHG7/RiotAPI-Challenger-2016-May/master/coloumn_1.jpg)

The settings for the tables top_list, top_list_BR, top_list_EUNE, top_list_KR, top_list_LAN, top_list_LAS, top_list_NA, top_list_OSCA, top_list_RU, top_list_TR are shown in "/coloumns_2.jpg".

![alt tag](https://raw.githubusercontent.com/TheHHG7/RiotAPI-Challenger-2016-May/master/coloumns_2.jpg)

After setting up the database you must put the hostname, user, password, database and api key in the following files:
- /BR/connect_db.php
- /EUNE/connect_db.php
- /EUW/connect_db.php
- /KR/connect_db.php
- /LAN/connect_db.php
- /LAS/connect_db.php
- /NA/connect_db.php
- /OCE/connect_db.php
- /RU/connect_db.php
- /TR/connect_db.php
- /connect_db.php

To update the information about the Top Champion Points List and Master and Challenger Master Score and Champion Points Lists for each server following files need to be executed which are located in their respected server folders:
- cron_store_playersData_master_challenger.php to update data about players in Master and Challenger League (better run it twice together so the error responses get deleted and can be set as scheduled task)
- top_list creator.php to update the Top Champion Points List (also can be ran as a scheduled task)
- data_collector.php gets the data of the players in the leagues of players already stored in database

The data collection files like data_collector.php or cron_store_playersData_master_challenger.php can be executed without any secret key for the purpose of the Riot API Challenge, but we will add a secret key after the contest is finished.

To complete this project we put in a lot of hours, as we wanted to give back to the League of Legends community. So we made something that we think everyone will use, we also added extra features that make it more fun for users to use our website like the ladders and check your live games.

Website examples:

Home Page - Search for summoner profile page
![alt tag](https://i.gyazo.com/bd7c44e5c579ee719474dc4ec8b0b8ea.jpg)

Summoner Profile Page
![alt tag](https://i.gyazo.com/ad7e9bfce50db05f673af7fed02db5bf.jpg)

Challenger & Master Ladder - Champion Points page
![alt tag](https://i.gyazo.com/49ddd63f2f65a30bc86f73c25f99f9e4.jpg)

Challenger & Master Ladder - Mastery Points page
![alt tag](https://i.gyazo.com/7019312ad714d733948a2bfe453ad06b.jpg)

Top Champion Mastery Ladder page
![alt tag](https://i.gyazo.com/751c4b1087443e6f5a860310811f8fd9.jpg)

Live Game Search Page
![alt tag](https://i.gyazo.com/deed10dc543636b25fc6e3efad6cc0b2.jpg)

Live Game Summoner Results page
![alt tag](https://i.gyazo.com/2acf175b5058bbb2d13ebe58e24eee6a.jpg)

Change Region and language page
![alt tag](https://i.gyazo.com/47cbf6d2644b8af5589ee68ce796dc83.jpg)

404 Error Profile search page
![alt tag](https://i.gyazo.com/dd29222b6c05edcd7b0bf57f85a635ba.jpg)

404 Error Live Game search page
![alt tag](https://i.gyazo.com/081b79f9ea26e2a21f9b9bf8af32a832.jpg)


LoLMastery.net is created by:
Aaron "ForsakenHound" and "TheHHG7"

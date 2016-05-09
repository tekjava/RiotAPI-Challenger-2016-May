# LoLMastery.ff - RiotAPI-Challenger-2016-May

THIS REPOSITORY IS FOR A RIOT API CHALLENGE ENTRY AND THE DATA IS PROVIDED BY RIOT AND ONLY RIOT

FOR A LIVE DEMO GOTO http://amazonsaver.uk/

With LoLMastery.ff everybody can access anybody's data about their champion masteries with full detail, in addition to that it also shows their ranked info with every champion they have played and their ranked status. You can also find a top list which is sorted by highest champion points, separate from that there is a master and challenger top list with their champion points and mastery scores so players can compare there mastery stats to top ranked players.

We also include a live game checker, that checks to see if a player is in game and will get all information about enemy and your own team, it provides ranked data and mastery data.

Also the web is accesible from multiple regions.

The data is stored in a database that is only used for LoLMastery.ff.

The functions in code are self explanatory but however due to lack of the production key, we have put sleep(x) in certain part of the code just so not to spam the api call and x can be changed if and when production key is available.

In order to make the code work you need MySQL database with server connection collation and databse collation set as utf8_bin. The database must contain the tables shown in "/tables_1.jpg" with their settings.

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

LoLMastery.ff is created by:
Aaron "ForsakenHound" and "TheHHG7"

<?php

    // basic db connection setup to use in other files, also remember to $conn->close();
    $host = ; // HOST HERE
    $user = ; // USER HERE
    $pass = ; // PASSWORD HERE
    $db = ; // DATABASE HERE

    $apiKey = ; // API KEY HERE

    $conn = new mysqli($host, $user, $pass, $db);

    if($conn->connect_error) {
        die("The following error has occured:<br>" . $conn->connect_error);
    }

    if($conn->set_charset('utf8')) {
        //echo 'Charset is: UTF-8<br>';
        header("Content-Type: text/html; charset=utf-8");
        ini_set("default_charset", 'utf-8');
    } else {
        //echo 'Charset is not: UTF-8<br>';
    }

?>

<?php
session_start();
header('Cache-control: private'); // IE 6 FIX

$serverchange_file;

if(isset($_GET['serverchange']))
{
    $serverchange = $_GET['serverchange'];

    // register the session and set the cookie
    $_SESSION['serverchange'] = $serverchange;

    setcookie("serverchange", $serverchange, time() + (3600 * 24 * 30));
}
else if(isset($_SESSION['serverchange']))
{
$serverchange = $_SESSION['serverchange'];
}
else if(isset($_COOKIE['serverchange']))
{
$serverchange = $_COOKIE['serverchange'];
}
else
{
$serverchange = 'EUW';
}


switch ($serverchange) {
  case 'KR':
  $serverchange_file = 'KR';
  break;

  case 'OCE':
  $serverchange_file = 'OCE';
  break;

  case 'RU':
  $serverchange_file = 'RU';
  break;

  case 'TR':
  $serverchange_file = 'TR';
  break;

  case 'NA':
  $serverchange_file = 'NA';
  break;

  case 'LAS':
  $serverchange_file = 'LAS';
  break;

  case 'LAN':
  $serverchange_file = 'LAN';
  break;

  case 'EUW':
  $serverchange_file = 'EUW';
  break;

  case 'EUNE':
  $serverchange_file = 'EUNE';
  break;

  case 'BR':
  $serverchange_file = 'BR';
  break;


  default:
  $serverchange_file = 'EUW';

}

header('Location: ./'.$serverchange_file);

?>

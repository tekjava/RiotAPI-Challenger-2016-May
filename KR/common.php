<?php
session_start();
header('Cache-control: private'); // IE 6 FIX

if(isSet($_GET['lang']))
{
$lang = $_GET['lang'];

// register the session and set the cookie
$_SESSION['lang'] = $lang;

setcookie("lang", $lang, time() + (3600 * 24 * 30));
}
else if(isSet($_SESSION['lang']))
{
$lang = $_SESSION['lang'];
}
else if(isSet($_COOKIE['lang']))
{
$lang = $_COOKIE['lang'];
}
else
{
$lang = 'kr';
}

switch ($lang) {
  case 'en':
  $lang_file = 'lang.en.php';
  break;

  case 'de':
  $lang_file = 'lang.de.php';
  break;

  case 'es':
  $lang_file = 'lang.es.php';
  break;
  
  case 'fr':
  $lang_file = 'lang.fr.php';
  break;
  
  case 'pl':
  $lang_file = 'lang.pl.php';
  break;
  
  case 'kr':
  $lang_file = 'lang.kr.php';
  break;
  
  case 'se':
  $lang_file = 'lang.se.php';
  break;
  
  case 'ja':
  $lang_file = 'lang.ja.php';
  break;
  
  case 'da':
  $lang_file = 'lang.da.php';
  break;
  
  case 'rom':
  $lang_file = 'lang.rom.php';
  break;
  
  case 'no':
  $lang_file = 'lang.no.php';
  break;
  
  case 'ru':
  $lang_file = 'lang.ru.php';
  break;
  
  case 'hu':
  $lang_file = 'lang.hu.php';
  break;
  
  case 'fi':
  $lang_file = 'lang.fi.php';
  break;
  
  case 'tr':
  $lang_file = 'lang.tr.php';
  break;
  
  case 'sl':
  $lang_file = 'lang.sl.php';
  break;
  
  case 'pt':
  $lang_file = 'lang.pt.php';
  break;
  
  case 'zh':
  $lang_file = 'lang.zh.php';
  break;
  
  case 'sr':
  $lang_file = 'lang.sr.php';
  break;
  
  case 'it':
  $lang_file = 'lang.it.php';
  break;



  default:
  $lang_file = 'lang.kr.php';

}

include_once 'languages/'.$lang_file;
?>
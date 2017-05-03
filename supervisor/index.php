<?php
// Initialisation
require_once('includes/init.php');
// Require the user to be logged in before they can see this page.
Auth::getInstance()->requireLogin();
// Set the title, show the page header, then the rest of the HTML
$page_title = 'Supervisor View';
include('./includes/header.php');
?>
<head>
<title>Sort Tetris - Supervisor View</title>
<style>
@import url("../style.css");
</style>
</head>
<body>
<h1>Sort Tetris - Site Administration</h1>
<?php 
include('display_login.php'); 
include('../global_settings.php');
?>
<h2>View Recent Scores for:</h2>

<?
$path = $_SERVER['REQUEST_SCHEME'] .'://'.$_SERVER['HTTP_HOST']. preg_replace('/\/supervisor\/.*/','/',$_SERVER['REQUEST_URI']);
$ch = curl_init($path."ajax.php?action=list-all-games");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = json_decode(curl_exec($ch));
curl_close($ch);

print '<ol id="list-games">'.PHP_EOL;
foreach($response as $game) {
  print '<li><a href="./scores.php?config='.$game->url.'&title='.urlencode($game->title).'">'.$game->title.'</a>'.PHP_EOL;
    }
print '</ol>';

?>
<?php include("../license.php"); ?>
<?php
if (isset($google_analytics_id)) {
  include_once('../google_analytics.php');
}
?>
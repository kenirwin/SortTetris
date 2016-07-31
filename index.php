<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

<head>
<?php
include ('global_settings.php'); 
if (isset($_GET['settings'])) {
    $filename = './settings/settings_'.$_GET['settings'].'.php';
    if (is_readable($filename)) {
        include($filename);
    }
}
else { 
    include('./settings/settings_bib.php'); 
    $_REQUEST['settings'] = $_GET['settings'] = 'bib';
}    
include('process_settings.php'); 
?>

<title><?php print($game_title); ?></title>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="cite-tetris.js"></script>
<style>
    @import 'https://fonts.googleapis.com/css?family=Press+Start+2P';
</style> 
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<?php
     if ($audioOK) { 
         include ("audio.php");
     }
?>
<?php print($game_header); ?>
<div id="game">
     <div id="item"><?php print($item_label_cap);?>:</div>
<div id="debug">Debug:</div>
<div id="score">Level: 1<br />Score: 0</div>
<div id="controls"></div>
<div id="long-stats"></div>                                         
<div id="grid">
<table id="game-table">
<tr><td id="row1"></td></tr>
<tr><td id="row2"></td></tr>
<tr><td id="row3"></td></tr>
<tr><td id="row4"></td></tr>
<tr><td id="row5"></td></tr>
<tr><td id="row6"></td></tr>
<tr><td id="row7"></td></tr>
<tr><td id="row8"></td></tr>
<tr><td id="row9"></td></tr>
<tr><td id="row10"></td></tr>
<tr><td id="row11"></td></tr>
<tr><td id="row12"></td></tr>
</table>
</div>
</div>
<?php include("license.php"); ?>
<div id="gameover"><h1 class="header">Game Over</h1>
<div>
<label for="gameover-score">Score:</label><span id="gameover-score"></span><br />
<label for="accuracy">Accuracy Bonus: </label><span id="accuracy"></span><br />
<label for="final-score">Final Score: </label><span id="final-score"></span>
</div>

<form id="name-entry">
<input type="text" placeholder="your name"  id="name" size="10">
<span id="name-submit" type="button" class="button">-></span>

</form>

<h3 id="name-display"></h3>

<h2>High Scores</h2>
<center>
<div id="leaderboard">If no high scores display, you may not be connected to a MySQL database. See the README file for installation instructions</div>
<div id="close-gameover" class="button inactive">Close</div>
</center>
</div>
<div id="pause-screen">
<h1>Paused</h1>
<p>Press space-bar to continue</p>
</div>

<?php
if (! empty($google_analytics_block)) {
    print $google_analytics_block;
}
?>

</html>

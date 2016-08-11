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
    include('process_settings.php'); 
?>
<title><?php print($game_title); ?></title>
<script type="text/javascript" src="jquery.js"></script>
<script src="https://ajax.google.com/ajax/libs/webfont/1.5.10/webfont.js"></script>
<script>
    WebFont.load({
        google: {
          families: ['Press Start 2P']
        },
        custom: {
                families: ['Atari'],
                urls: ['style.css'] 
        }
        });
</script>
<script type="text/javascript" src="sort-tetris.js"></script>
<style>
    @import 'https://fonts.googleapis.com/css?family=Press+Start+2P';
</style> 
<link rel="stylesheet" type="text/css" href="style.css" />
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
<div id="pause-wrapper">
<div id="pause-background"></div>
<div id="pause-text">
<h1>Paused</h1>
<p>Press space-bar to continue</p>
<p>Note: You will not be able to select an answer for the current block after un-pausing the game.</p>
</div>
</div>
<?php
if ($audioOK == true) {
  print '<div id="audio-toggle"><img src="images/audioOn.png" id="audio-toggle-button"></div>';
}
?>

<img id="preloadImg"></div>
<?php
}
else {
?>
<title>Sort Tetris - Choose a Game</title>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<h1>Sort Tetris</h1>
    <div id="description">
    <p>Sort Tetris is an educational falling-blocks style game designed to provide practice sorting things into categories. It can be adapted to sort any short textual or small visual items into 2-5 categories. Examples include:</p>
<ul>
<li>Animals: Amphibian, Bird, Fish, Mammal, Reptile</li>
<li>Bibliographic Entries: Article, Book, Book Chapter</li>
<li>Instruments: Brass, Percussion, Strings, Woodwind</li>
<li>U.S. Presidents: Democrat, Republican</li>
</ul>

    <p><b>Playing the Game:</b> Sortable items will fall down the page. Select the approriate category from the green buttons to the right of the game. Correct answers will disappear; incorrect answers will fall to the bottom of the screen. The game will speed up as you answer more items correctly.</p>
</div>

<h2>Choose a Game</h2>
<?
    if (preg_match('/^(.+)\//',$_SERVER['REQUEST_URI'], $m)) {
        $path = 'http://' . $_SERVER['HTTP_HOST'] . $m[1];
    }
    $ch = curl_init($path."/ajax.php?action=list-games");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = json_decode(curl_exec($ch));
    curl_close($ch);
    fclose($fp);

    
    print '<ol id="list-games">'.PHP_EOL;
    foreach($response as $game) {
        print '<li><a href="?settings='.$game->url.'">'.$game->title.'</a>'.PHP_EOL;
    }
    print '</ol>';
}
?>

<?php include("license.php"); ?>

<?php
if (! empty($google_analytics_block)) {
    print $google_analytics_block;
}
?>

</html>

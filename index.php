<?php
session_start();
$mysql_connected = TestMysql();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

<head>
<script type="text/javascript" src="./lib/jquery.js"></script>
<script type="text/javascript" src="./lib/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="lib/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="style.css">

<script>
    $(document).ready(function() { 
	$form = $('#inst-form');
	$('#institution-select').click(function() {
	    $('#inst-display').hide();
	    $('#inst-form').show();
	  });
	$('#form-submit').click(function() {
	    var inst_id = $('#inst-id').val();
	    var inst_name = $('#inst-id option:selected').text();
	    if (isNaN(inst_id)) {
	      inst_id = 0;
	      inst_name = 'None';
	    }
            $('#inst-name').val(inst_name);
	    $('inst-id-score').val(inst_id);
	    $.ajax({
	      url: './inst_select.php',
		  data: $form.serialize(),
		  success: function(result) {		
		  $('#inst-display-name').text(inst_name);
		  $('#inst-form').hide();
		  $('#inst-display').show();
		}
	      });
	  });
	$('#inst-id').change(function() {
	    $('#form-submit').click();
	  });
      });
</script>

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
</head>
<body>
<?php
     if ($audioOK) { 
         include ("audio.php");
     }
?>
<?php print($game_header); ?>
<div id="game-inst-wrapper">
   <?php InstSelector(); ?>
</div>
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
<label for="final-score" id="final-label">Final Score: </label><span id="final-score"></span>
</div>

<?php
			   if ($mysql_connected) {
?>
<form id="name-entry">
<input type="text" placeholder="your name"  id="name" size="10">
<input type="hidden" id="inst-id-score" value="<?php if (isset($_SESSION['inst_id'])) { print($_SESSION['inst_id']);} ?>" />
<span id="name-submit" type="button" class="button">-></span>
</form>
<h3 id="name-display"></h3>
<?php
			   }
?>

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

																			      
<?php
if ($mysql_connected && $display_supervisor_reg_links && $allow_supervisor_registration) {
  print '<p><b>For Supervisors and Teachers:</b> If you would like your employees or students to play Sort Tetris, they can play as guests or you can <a href="supervisor/register.php">register as a supervisor</a>. Registered supervisors will be able to track the progress of users who identify their institutional affiliation using the green "Playing for Work/School" pulldown. Registered supervisors can <a href="supervisor/login.php">log in</a> here.</p>';
}
?>
																							    </div>


<div id="game-selector">
<?php InstSelector(); ?>

<h2>Choose a Game</h2>
<?php
    if (preg_match('/^(.+)\//',$_SERVER['REQUEST_URI'], $m)) {
        $path = 'http://' . $_SERVER['HTTP_HOST'] . $m[1];
    }
    $ch = curl_init($path."/ajax.php?action=list-games");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = json_decode(curl_exec($ch));
    curl_close($ch);
    
    print '<ol id="list-games">'.PHP_EOL;
    foreach($response as $game) {
        print '<li><a href="?settings='.$game->url.'">'.$game->title.'</a>'.PHP_EOL;
    }
    print '</ol>';
}
?>
</div>

<?php include('license.php'); ?>

<?php
if (isset($google_analytics_id)) {
  include_once('google_analytics.php');
}
?>

</html>
<?php
function InstSelector() {
  global $display_institution_select;
  if ($display_institution_select) { 
    if (isset($_SESSION['inst_id'])) {
      $selector_display="none";
      $selected_display="block";
    }
    else {
      $selector_display="block";
      $selected_display="none";
    }
    
    if(preg_match("/(.*\/)/",$_SERVER['REQUEST_URI'],$m)) {
      $curr_dir = $m[1];
    }
    $path = $_SERVER['REQUEST_SCHEME'] .'://'.$_SERVER['HTTP_HOST']. $curr_dir;
    $ajax_url = $path.'ajax.php?action=list-institutions';
    $json = file_get_contents($ajax_url);
    $opts = '<option>--Select an Institution--</option>';
    $inst_ct = sizeof(json_decode($json));
    if ($inst_ct > 0) {
      foreach(json_decode($json) as $data) {
	$opts .=  '<option value="'. $data->institution_id .'">'.$data->institution_name.'</option>'.PHP_EOL;
      }
      $opts.= '<option value="0">None</option>';
      print '<div class="button" id="institution-select">Playing for Work/School?'.PHP_EOL;
      print '<form id="inst-form" style="display:'.$selector_display.'"><select name="inst_id" id="inst-id">'.$opts.'</select><input type="hidden" name="inst_name" id="inst-name" value=""><input type="button" value="Submit" name="set_institution" id="form-submit"/></form>'.PHP_EOL;
      print '<div id="inst-display" style="display:'.$selected_display.'"><span id="inst-display-name">';
      if (isset($_SESSION['inst_name'])) { print $_SESSION['inst_name']; }
      print '</span> <span id="inst-display-edit">Edit</span></div>'.PHP_EOL;
      print '</div>'.PHP_EOL;
    } 
  }
  }

function TestMysql() {
    if(preg_match("/(.*\/)/",$_SERVER['REQUEST_URI'],$m)) {
      $curr_dir = $m[1];
    }
    $path = $_SERVER['REQUEST_SCHEME'] .'://'.$_SERVER['HTTP_HOST']. $curr_dir;
  $url = $path.'ajax.php?action=test-mysql';
  $response = json_decode(file_get_contents($url));
  return($response->success);
}

?>
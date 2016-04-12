<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

<head>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="bibliography.js"></script>
<script type="text/javascript" src="cite-tetris.js"></script>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
    <audio id='myaudio' loop='loop'>
      <source src='Korobeiniki.mp3' type='audio/mp3'>
    </audio>

    <script>
   var audio=document.getElementById('myaudio');
   audio.playbackRate = 1;
   function playaudio()
      {
        audio.play()
      }
    function pauseaudio()
      {
       audio.pause()
      }
    function speedUp() 
      {
	var newRate = audio.playbackRate + 0.2;
	if (newRate < 3) { 
	  audio.playbackRate = newRate;
	}
      }
    function slowDown() 
      {
	var newRate = audio.playbackRate - 0.2;
	if (newRate < .5) { 
	  audio.playbackRate = newRate;
	}
      }
    </script>

<img src="logo.png" />
<div id="game">
<div id="citation">Citation:</div>
<div id="debug">Debug:</div>
<div id="score">Level: 1<br />Score: 0</div>
<div id="controls"></div>
<div id="grid">
<table>
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
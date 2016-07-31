<?php
$buttons = array ('mammal','bird','reptile','amphibian','fish');
$data_file = 'animals.json';
$item_label = 'animal';
$game_title = 'Animal Tetris';
$game_logo_file = ''; //leave blank for text title

/* Scoring, Win conditions */

$point_units = 50; // base score per correct
$drop_delay = 400; // milliseconds between move down
$delay_decrease_per_level=50; //speed-up by x ms/drop 
$height = 12; // number of wrong lines allowed before end of game
$correct_per_level = 3; // level up after this many correct
$win_at_level = 3; // automatic win when this level reached

/* 
   Block colors: main + bevels: top, right, bottom, left 
   You can override the block colors with your own colors by 
   un-commenting the next variable and changing the colors.
   Otherwise, the default colors will be used
*/
/*
$colors_override = [
    ['#00e427', '#bdffca', '#009c1a', '#00961a', '#2dff55'], //green
    ['#e4de00','#ffffbd','#a39c00','#968f00','#fff83a'], //yellow
    ['#00e4e4','#c4ffff','#00aaaa','#009696','#34ffff'], //lightblue
    ['#ff4500','#ffe4d8','#be3000','#b12c00','#ff8155'], //orange
    ['#ff00ff','#ffd8fe','#bb00be','#ad00b1','#fd55ff'], //pink
    ['#009fd4','#ade8ff','#007193','#006786','#2accff'], //blue
    //['#e40027','#ffbdca','#a3001a','#96001a','#ff345b'], //red
    //['#9c13e4','#ebbdff','#6f009c','#620096','#c441ff'], //purple
];
*/
?>


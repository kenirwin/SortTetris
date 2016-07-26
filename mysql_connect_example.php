<?php
/* the secret word is used to prevent someone from spamming your leaderboard 
   database table. Enter an arbitrary string of characters. */
$secret_word = ""; //fill in an arbitrary character-string, e.g. 'asdfasdf'

/* mysql connection info */
$host = "localhost";
$db = "";
$user = "";
$pass = "";
$charset = "utf8";

function ConnectPDO($host,$db,$user,$pass,$charset) { 
$db = new PDO("mysql:host=$host;dbname=$db;charset=$charset", "$user", "$pass");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
return $db;
}
?>